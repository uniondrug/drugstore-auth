<?php
/**
 * 重要说明
 * 1. 本文件由Postman命令脚本自动生成, 请不要修改, 若需修改
 *    请通过`php console postman`命令重新生成.
 * 2. 本脚本在生成时, 依赖所在项目的Controller有 `@Sdk method`定义,
 *    同时, 项目根目录下的`postman.json`需有`sdk`、`sdkLink`定义
 * 3. 发布SDK，请将本文件放到`uniondrug/service-sdk`项目
 *    的`src/Exports/Modules`目录下，并发重新发布release版本.
 * @author PostmanCommand
 * @date   2022-01-01
 * @time   Sat, 01 Jan 2022 17:18:50 +0800
 */
namespace Uniondrug\ServiceSdk\Exports\Modules;

use Uniondrug\ServiceSdk\Exports\Abstracts\SdkBase;
use Uniondrug\ServiceSdk\Bases\ResponseInterface;

/**
 * PsDstoreCartSdk
 * @package Uniondrug\ServiceSdk\Modules
 */
class GwMpTradeSdk extends SdkBase
{
    /**
     * 服务名称
     * 自来`postman.json`文件定义的`sdkService`值
     * @var string
     */
    protected $serviceName = 'gw-mp-trade';

    /**
     * 配送方式计算
     * @param array|object $body  入参类型
     * @param null         $query Query数据
     * @param null         $extra 请求头信息
     * @return ResponseInterface
     */
    public function deliveryMethodTrial($body, $query = null, $extra = null)
    {
        return $this->restful("POST", "/lcsvr/svr/delivery/method/trial", $body, $query, $extra);
    }

    /**
     * 运费试算
     * @param array|object $body  入参类型
     * @param null         $query Query数据
     * @param null         $extra 请求头信息
     * @return ResponseInterface
     */
    public function feeTrial($body, $query = null, $extra = null)
    {
        return $this->restful("POST", "/lcsvr/svr/delivery/fee/trial", $body, $query, $extra);
    }
}
