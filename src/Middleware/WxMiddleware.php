<?php

/**
 * 基于TOKEN的认证方式。
 */

namespace Uniondrug\DrugstoreAuth\Middleware;

use Phalcon\Http\RequestInterface;
use Uniondrug\DrugstoreAuth\Logic\DrugstoreAuthLogic;
use Uniondrug\DrugstoreAuth\Service\DrugstoreAuthService;
use Uniondrug\Middleware\DelegateInterface;
use Uniondrug\Middleware\Middleware;
use App\Errors\Error;

/**
 * Class WxMiddleware
 * @package Uniondrug\WxMiddleware
 * @property \Uniondrug\DrugstoreAuth\Service\WxService $wxAuthService
 */
class WxMiddleware extends Middleware
{
    /**
     * @param RequestInterface $request
     * @param DelegateInterface $next
     * @return \Phalcon\Http\ResponseInterface
     */
    public function handle(RequestInterface $request, DelegateInterface $next)
    {
        // WhiteList
        if ($this->wxAuthService->isWhiteList($request->getURI())) {
            return $next($request);
        }
        $origin = $request->getHeader('origin');
        switch ($origin) {
            case 'dtp':
                // 假如是dtp小程序
                if ($this->dtp($request)) {
                    return $next($request);
                }
                break;
            case 'merchant':
                // 假如是连锁小程序
                if ($this->merchant($request)) {
                    return $next($request);
                }
                break;
            default:
                // 假如是微信环境
                if ($this->wx($request)) {
                    return $next($request);
                }
                break;
        }
    }

    /**
     * dtp小程序认证
     * @return mixed|\Phalcon\Http\Response
     * @throws Error
     */
    private function dtp($request)
    {
        $authType = 25;
        $openId = $this->wxAuthService->getTokenFromRequest($request);
        // 用openid获取用户
        $openInfo = $this->wxAuthService->infoOpenId([
            'oauthType' => $authType,
            'openId' => $openId
        ]);
        if (isset($openInfo['memberId']) && $openInfo['memberId']) {
            $member = $this->wxAuthService->getUser([
                'memberId' => $openInfo['memberId']
            ]);
            $_SERVER['member'] = [
                'memberId' => $openInfo['memberId'],
                'wxOpenid' => $openId,
                'name' => $member['memberName'] ?? '',
                'mobile' => $member['account'] ?? ''
            ];
            return true;
        } else {
            return $this->serviceServer->withError('Unauthorized', 401);
        }
    }

    /**
     * 连锁小程序认证
     * @return mixed|\Phalcon\Http\Response
     * @throws Error
     */
    private function merchant($request)
    {
        $authType = 24;
        $openId = $this->wxAuthService->getTokenFromRequest($request);
        // 用openid获取用户
        $openInfo = $this->wxAuthService->infoOpenId([
            'oauthType' => $authType,
            'openId' => $openId
        ]);
        if (isset($openInfo['memberId']) && $openInfo['memberId']) {
            $member = $this->wxAuthService->getUser([
                'memberId' => $openInfo['memberId']
            ]);
            $_SERVER['member'] = [
                'memberId' => $openInfo['memberId'],
                'wxOpenid' => $openId,
                'name' => $member['memberName'] ?? '',
                'mobile' => $member['account'] ?? ''
            ];
            return true;
        } else {
            return $this->serviceServer->withError('Unauthorized', 401);
        }
    }

    /**
     * 微信环境认证
     * @return mixed|\Phalcon\Http\Response
     * @throws \Exception
     */
    private function wx($request)
    {
        // 1. 提取TOKEN, return 401
        $token = $this->wxAuthService->getTokenFromRequest($request);
        if (empty($token)) {
            $this->di->getLogger('auth')->debug(sprintf("[Auth] Unauthorized."));
            return $this->serviceServer->withError('Unauthorized', 401);
        }
        // 2. 校验TOKEN, return 403
        if (!$member = $this->wxAuthService->checkToken($token)) {
            $this->di->getLogger('auth')->debug(sprintf("[Auth] Invalid Token: token=%s", $token));
            return $this->serviceServer->withError('Forbidden: Invalid Token', 403);
        }
        $_SERVER['member'] = $member;
        return true;
    }

}
