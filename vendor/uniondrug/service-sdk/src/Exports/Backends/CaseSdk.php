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
 * @date   2019-12-26
 * @time   Thu, 26 Dec 2019 17:12:15 +0800
 */
namespace Uniondrug\ServiceSdk\Exports\Backends;

use Uniondrug\ServiceSdk\Exports\Abstracts\SdkBase;
use Uniondrug\ServiceSdk\Bases\ResponseInterface;

/**
 * Class CaseSdk
 * @package Uniondrug\ServiceSdk\Exports\Modules
 */
class CaseSdk extends SdkBase
{
    /**
     * 服务名称
     * 自来`postman.json`文件定义的`sdkService`值
     * @var string
     */
    protected $serviceName = 'tpa.outreach.backend';

    /**
     * 赔案信息上传接口
     * @link https://uniondrug.coding.net/p/module.sketch/git/blob/development/docs/api/Admin/Api/CaseController/commitAction.md
     * @param array $body 入参类型
     * @return ResponseInterface
     */
    public function case($body)
    {
        return $this->restful("POST", "/admin/api/case/commit", $body);
    }
}
