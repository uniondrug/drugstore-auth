<?php
/**
 * @author: xingshenqiang<xingshenqiang@uniondrug.cn>
 * @date  :   2019-05-13
 */
namespace Uniondrug\ServiceSdk\Modules;

use Uniondrug\Service\ClientResponseInterface;
use Uniondrug\ServiceSdk\Sdk;
use Uniondrug\ServiceSdk\ServiceSdkInterface;

/**
 * java push服务
 * Class JavaPushSdk
 * @package Uniondrug\ServiceSdk\Modules
 */
class JavaPushSdk extends Sdk implements ServiceSdkInterface
{
    protected $serviceName = 'javaPush';

    /**
     * 添加体检数据
     * @link
     * @param array $body
     * @return ClientResponseInterface
     */
    public function pushNotify($body)
    {
        return $this->restful(static::METHOD_POST, '/push/notify', $body);
    }

    /**
     * 药联到家push
     * @link
     * @param array $body
     * @return ClientResponseInterface
     */
    public function yaoliandaojiaPush($body)
    {
        return $this->restful(static::METHOD_POST, 'yldj/push', $body);
    }

    /**
     * 链接
     * @param $body
     * @return ClientResponseInterface
     * @throws \Uniondrug\ServiceSdk\Exception
     */
    public function pushQuery($body)
    {
        return $this->restful(static::METHOD_POST, '/order/push/query', $body);
    }
}
