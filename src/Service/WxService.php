<?php
/**
 * TokenAuthService.php
 */
namespace Uniondrug\DrugstoreAuth\Service;

use Phalcon\Config;
use App\Errors\Error;
use Phalcon\Http\RequestInterface;
use Uniondrug\Framework\Services\Service;
use Uniondrug\Redis\Client;

/**
 * Class WxService
 * @package Uniondrug\DrugstoreAuth
 */
class WxService extends Service
{
    protected $whiteList = null;

    protected $redis = null;

    public function getTokenFromRequest(RequestInterface $request)
    {
        $authHeader = $request->getHeader('Authorization');
        return trim(str_replace('Bearer', '', $authHeader));
    }

    public function isWhiteList($uri)
    {
        $regexp = $this->getWhiteList();
        if ($regexp !== ''){
            return preg_match($regexp, preg_replace("/\?(\S*)/", "", $uri)) > 0;
        }
        return false;
    }

    public function getWhiteList()
    {
        $whiteList = $this->config->path('auth.whitelist');
        if (is_string($whiteList) && $whiteList !== ''){
            return $whiteList;
        } else {
            return '';
        }
    }

    /**
     * @param $token
     * @return AuthMemberStruct|bool
     * @throws \Exception
     */
    public function checkToken($token)
    {
        $token = explode('.', $token);
        if (count($token) != 3) return false;
        list($headerEncoded, $payloadEncoded, $signatureEncoded) = $token;
        $dataEncoded = "$headerEncoded.$payloadEncoded";
        $signature = $this->base64url_decode($signatureEncoded);
        $publicKeyResource = openssl_pkey_get_public(file_get_contents($this->config->path('auth.public_key_path')));
        $result = openssl_verify($dataEncoded, $signature, $publicKeyResource, 'sha256');
        openssl_pkey_free($publicKeyResource);
        if ($result === -1){
            throw new \Exception("Failed to verify signature: ".openssl_error_string());
        }
        elseif ($result){
            $payload = json_decode($this->base64url_decode($payloadEncoded), true);
            $key = $payload['version']['key'];
            $version = $this->getRedis()->get($key);
            return $version == $payload['version']['value'] ? $payload : false;
        }
        else{
            return false;
        }
    }

    /**
     * @return \Redis
     */
    protected function getRedis()
    {
        if (!$this->redis){
            $redisConfig = $this->config->path('auth.redis.options');
            $this->redis = new Client($redisConfig->toArray());
        }
        return $this->redis;
    }

    protected function base64url_decode($data)
    {
        return base64_decode(str_replace(['-','_'], ['+','/'], $data));
    }

    /**
     * openssl解密openid
     * @param $encryptedOpenid
     * @return mixed
     * @throws \Exception
     */
    public function opensslDecryptOpenid($encryptedOpenid)
    {
        $publicKeyFilePath = $this->config->path('auth.public_key_path');
        $publicKey = openssl_pkey_get_public(file_get_contents($publicKeyFilePath));
        $ret = openssl_public_decrypt(base64_decode($encryptedOpenid), $decryptData, $publicKey);
        if(empty($ret)){
            throw new \Exception("openssl decrypt fail ".openssl_error_string());
        }
        openssl_pkey_free($publicKey);
        return $decryptData;
    }

    /**
     * 获取openid
     * @param $param
     * @return mixed
     * @throws Error
     */
    public function infoOpenId($param)
    {
        $res = $this->serviceSdk->module->javaMember->infoOpenId($param);
        if ($res->hasError()) {
            return false;
        }
        return $res->toArray();
    }

    /**
     * 获取用户
     * @param $param
     * @return array
     * @throws Error
     */
    public function getUser($param)
    {
        $result = $this->serviceSdk->module->javaMember->queryBy($param);
        if ($result->hasError()) {
            throw new Error($result->getError(), $result->getErrno());
        }
        return $result->toArray();
    }
}
