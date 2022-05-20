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
                if ($this->auth($request, 25)) {
                    return $next($request);
                }
                break;
            case 'merchant':
                // 假如是连锁小程序
                if ($this->auth($request, 24)) {
                    return $next($request);
                }
                break;
            case 'alipayMerchant':
                // 假如是连锁小程序
                if ($this->merchant($request, 34)) {
                    return $next($request);
                }
                break;
            case 'alipayDtp':
                // 假如是连锁小程序
                if ($this->merchant($request, 35)) {
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
     * 认证
     * @param $request
     * @return void
     */
    private function auth($request, $authType)
    {
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
            throw new \Exception('Unauthorized', 401);
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
            throw new \Exception('Unauthorized', 401);
        }
        // 2. 校验TOKEN, return 403
        if (!$member = $this->wxAuthService->checkToken($token)) {
            $this->di->getLogger('auth')->debug(sprintf("[Auth] Invalid Token: token=%s", $token));
            throw new \Exception('Forbidden: Invalid Token', 403);
        }
        $_SERVER['member'] = $member;
        return true;
    }

}
