<?php
/**
 * 重要说明
 * 1. 本文件由Postman命令脚本自动生成, 请不要修改, 若需修改
 *    请通过`php console postman`命令重新生成.
 * 2. 本脚本在生成时, 依赖所在项目的Controller有 `@Sdk method`定义,
 *    同时, 项目根目录下的`postman.json`需有`sdk`、`sdkLink`定义
 * 3. 发布SDK，请将本文件放到`uniondrug/service-sdk`项目
 *    的`src/Exports/Managements`目录下，并发重新发布release版本.
 * @author PostmanCommand
 * @date   2022-01-20
 * @time   Thu, 20 Jan 2022 10:17:13 +0800
 */
namespace Uniondrug\ServiceSdk\Exports\Modules;

use Uniondrug\ServiceSdk\Exports\Abstracts\SdkBase;
use Uniondrug\ServiceSdk\Bases\ResponseInterface;

/**
 * 小程序服务
 * Class GsDpspGsCatalogSdk
 * @package Uniondrug\ServiceSdk\Exports\Modules
 */
class GsDpspMiniProgramSdk extends SdkBase
{
    /**
     * 服务名称
     * 自来`postman.json`文件定义的`sdkService`值
     * @var string
     */
    protected $serviceName = 'gs-dpsp-miniprogram';

    /**
     * 小程序发消息
     * @param      $body
     * @param null $query
     * @param null $extra
     * @return \Uniondrug\ServiceSdk\Bases\Response|ResponseInterface
     */
    public function wxSendMessage($body, $query = null, $extra = null)
    {
        return $this->restful("POST", "/wx/send/message", $body, $query, $extra);
    }

    /**
     * 生成二维码
     * @param      $body
     * @param null $query
     * @param null $extra
     * @return \Uniondrug\ServiceSdk\Bases\Response|ResponseInterface
     */
    public function wxMakeQrcode($body, $query = null, $extra = null)
    {
        return $this->restful("POST", "/wx/make/qrcode", $body, $query, $extra);
    }

    /**
     * @param $body
     * @param null $query
     * @param null $extra
     * @return \Uniondrug\ServiceSdk\Bases\Response|ResponseInterface
     */
    public function wxAccessToken($body, $query = null, $extra = null)
    {
        return $this->restful("POST", "/wx/access/token", $body, $query, $extra);
    }
}