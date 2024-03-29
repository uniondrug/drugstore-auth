<?php
/**
 * Created by PhpStorm.
 * User: weng
 * Date: 9/6/21
 * Time: 4:39 PM
 */
namespace Uniondrug\ServiceSdk\Exports\Modules;

use Uniondrug\ServiceSdk\Bases\ResponseInterface;
use Uniondrug\ServiceSdk\Exports\Abstracts\SdkBase;

/**
 * JmWebMossSdk
 * @package Uniondrug\ServiceSdk\Exports\Modules
 */
class JmWebMossSdk extends SdkBase
{
    /**
     * 服务名称
     * @var string
     */
    protected $serviceName = 'uniondrug-moss-web';

    /**
     * 连锁用户分页
     * @param $body
     * @return ResponseInterface
     * @link
     */
    public function workerPageByOrganization($body)
    {
        return $this->restful(static::METHOD_POST, '/worker/pageByOrganization', $body);
    }

    /**
     * 连锁用户分页
     * @param $body
     * @return ResponseInterface
     * @link
     */
    public function workerQueryByUnitId($body)
    {
        return $this->restful(static::METHOD_POST, '/worker/queryByUnitId', $body);
    }

    /**
     * 连锁用户详情
     * @param $body
     * @return ResponseInterface
     * @link
     */
    public function workerManDetail($body)
    {
        return $this->restful(static::METHOD_POST, '/worker/workerManDetail', $body);
    }
}