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
 * Class TokenAuthMiddleware
 * @package Uniondrug\TokenAuthMiddleware
 * @property \Uniondrug\DrugstoreAuth\Service\DrugstoreAuthService $drugstoreAuthService
 */
class DrugstoreAuthMiddleware extends Middleware
{
    private $partnerOrgan = null;
    private $storeOrgan = null;
    private $dtpStoreOrgan = null;
    private $dtpPartnerOrgan = null;
    private $commonStoreOrgan = null;
    private $commonPartnerOrgan = null;
    private $configs = null;
    const USER_CACHE = 'APP:USER_ID_';
    const NOW_STORE_CACHE = 'APP:AUTH_MERCHANT_ID_';
    const COMMON_STORE_CACHE = 'APP:COMMON_AUTH_STORE_ID_';
    const DTP_STORE_CACHE = 'APP:DTP_AUTH_STORE_ID_';

    /**
     * @param RequestInterface  $request
     * @param DelegateInterface $next
     * @return \Phalcon\Http\ResponseInterface
     */
    public function handle(RequestInterface $request, DelegateInterface $next)
    {
        // 检查白名单
        $isWhite = $this->drugstoreAuthService->checkIsWhite($this->request->getURI());
        if ($isWhite) {
            return $next($request);
        }
        // 获取token
        $token = $this->drugstoreAuthService->getTokenFromRequest($request);
        if (!$token) {
            throw new Error(401, 'Forbidden: Invalid Token');
        }
        // 获取缓存
        if (!$assistantId = $this->drugstoreAuthService->getAssistantByToken($token)) {
            $userToken = $this->drugstoreAuthService->tokenDetail([
                'token' => $token
            ]);
            // 判断有没有
            if (!$userToken) {
                throw new Error(401, 'Forbidden: Invalid Token');
            }
            // 判断状态以及过期时间
            if ($userToken['status'] != DrugstoreAuthService::TOKEN_STATUS_NORMAL || strtotime($userToken['gmtExpired']) < time()) {
                throw new Error(401, 'Forbidden: Invalid Token');
            }
            $assistantId = $userToken['assistantId'];
            $this->drugstoreAuthService->setTokenCache($token, $assistantId, $this->config->path('drugAuth.tokenCacheTime'));
        }
        DrugstoreAuthLogic::factory([
            'assistantId' => $assistantId
        ]);
        $json = $request->getJsonRawBody();
        $json->thisLoginAssistantId = $assistantId;
        $request->setRawBody(json_encode($json, JSON_UNESCAPED_UNICODE));
        return $next($request);
    }
}
