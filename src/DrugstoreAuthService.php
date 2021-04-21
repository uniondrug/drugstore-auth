<?php
/**
 * TokenAuthService.php
 */
namespace Uniondrug\DrugstoreAuth;

use Phalcon\Config;
use Phalcon\Http\RequestInterface;
use Uniondrug\Framework\Services\Service;

/**
 * Class DrugstoreAuthService
 * @package Uniondrug\DrugstoreAuth
 */
class DrugstoreAuthService extends Service
{
    const TOKEN_STATUS_NORMAL = 1;

    /**
     * 检查是否是白名单
     * @param $url
     * @return bool
     */
    public function checkIsWhite($url)
    {
        $whiteController = $this->router->getControllerName();
        $whiteControllerList = $this->config->path('drugAuth.whiteController');
        if ($whiteControllerList->offsetExists($whiteController)) {
            return true;
        }
        $whiteRouteList = $this->config->path('drugAuth.whiteUrl');
        if ($whiteRouteList->offsetExists($url)) {
            return true;
        }
        return false;
    }

    /**
     * 从请求信息中获取Token. 来源包括请求头，QueryString。不允许将Token放在JSON的body里面。
     * @param \Phalcon\Http\RequestInterface $request
     * @return null|string
     */
    public function getTokenFromRequest(RequestInterface $request)
    {
        $token = null;
        $authHeader = $request->getHeader('Authorization');
        if (!empty($authHeader) && preg_match("/^Bearer\s+([_a-zA-Z0-9\-]+)$/", $authHeader, $matches)) {
            $token = $matches[1];
        } else {
            $token = $request->getQuery("token", "string", null);
            if (!empty($token)) {
                unset($_GET['token']);
            } else {
                $token = $request->getPost('token', 'string', null);
                if (!empty($token)) {
                    unset($_POST['token']);
                }
            }
        }
        return $token;
    }

    /**
     * 用token获取店员id
     * @param $token
     * @return null
     */
    public function getAssistantByToken($token)
    {
        $result = $this->redis->get('APP:TOKEN:'.$token);
        if ($result && $this->isJson($result)) {
            $result = json_decode($result, true);
            if (isset($result['assistantId'])) {
                return $result['assistantId'];
            }
        }
        return null;
    }

    /**
     * 设置token缓存
     * @param           $token
     * @param           $assistantId
     * @param float|int $expireTime
     */
    public function setTokenCache($token, $assistantId, $expireTime = 3600)
    {
        if (!$expireTime) {
            $expireTime = 3600;
        }
        $this->redis->setex('APP:TOKEN:'.$token, $expireTime, json_encode([
            'assistantId' => $assistantId
        ]));
    }

    /**
     * 用token获取店员id
     * @param $token
     * @return null
     */
    public function setTokenExpire($token)
    {
        $this->redis->del('APP:TOKEN:'.$token);
    }

    /**
     * 判断是否是json
     * @param $string
     * @return bool
     */
    public function isJson($string)
    {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }

    /**
     * 获取登录token
     * @param $params
     * @return array
     * @throws Error
     */
    public function tokenDetail($params)
    {
        $this->di->getLogger('udappModule')->debug('获取登录token详情：'.json_encode($params));
        $result = $this->serviceSdk->module->udapp->tokenDetail($params);
        if ($result->hasError()) {
            $this->di->getLogger('udappModule')->debug('获取登录token报错：'.$result->getError());
            return [];
        }
        $this->di->getLogger('udappModule')->debug('获取登录token反参：'.json_encode($result->toArray()));
        return $result->toArray();
    }

    /**
     * 店员详情
     * @param $params
     * @return array
     * @throws Error
     */
    public function assistantDetail($params)
    {
        $this->di->getLogger('clerkModule')->debug('店员详情参数:'.json_encode($params));
        $result = $this->serviceSdk->module->clerk->assistantDetail($params);
        if ($result->hasError()) {
            $this->di->getLogger('clerkModule')->debug('店员详情错误:'.$result->getError());
            throw new Error($result->getErrno(), $result->getError());
        }
        $this->di->getLogger('clerkModule')->debug('店员详情返回值:'.json_encode($result->toArray()));
        return $result->toArray();
    }

    /**
     * 用组织id获取信息
     * @param $organId
     * @return array
     * @throws Error
     */
    public function getByOrganId($organId)
    {
        $params = [
            'organizationId' => $organId
        ];
        $this->di->getLogger('merchantModule')->debug('用组织id获取信息参数:'.json_encode($params));
        $organization = $this->serviceSdk->module->merchant->infoOrgabuzeBase($params);
        if ($organization->hasError()) {
            $this->di->getLogger('merchantModule')->debug('用组织id获取信息错误:'.$organization->getError());
            throw new Error($organization->getErrno(), $organization->getError());
        }
        $this->di->getLogger('merchantModule')->debug('用组织id获取信息结果:'.json_encode($organization->toArray()));
        return $organization->toArray();
    }

    /**
     * 获取连锁配置
     * @param $params
     * @return array|bool
     */
    public function configStatus($params)
    {
        $this->di->getLogger('udappModule')->debug('验证登录信息详情：'.json_encode($params));
        $result = $this->serviceSdk->module->udapp->configStatus($params);
        if ($result->hasError()) {
            $this->di->getLogger('udappModule')->debug('验证登录信息报错：'.$result->getError());
            return false;
        }
        $this->di->getLogger('udappModule')->debug('验证登录信息反参：'.json_encode($result->toArray()));
        return $result->toArray();
    }
}
