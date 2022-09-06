<?php
/**
 * @author kuanxing <346300265@qq.com>
 * @date   2018-06-21
 */
namespace Uniondrug\ServiceSdk\Modules;

use Uniondrug\Service\ClientResponseInterface;
use Uniondrug\ServiceSdk\Sdk;
use Uniondrug\ServiceSdk\ServiceSdkInterface;
use Uniondrug\Structs\StructInterface;

/**
 * 财务结算中心
 * @package Uniondrug\ServiceSdk\Modules
 */
class FinanceSdk extends Sdk implements ServiceSdkInterface
{
    protected $serviceName = 'finance';

    /**
     * 结算单列表
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/StatementsController/listAction.md
     * @param array|StructInterface $body
     * @return ClientClientResponseInterface
     */
    public function statementsList($body)
    {
        return $this->restful(static::METHOD_POST, "/statements/list", $body);
    }

    /**
     * 结算单结算数据汇总接口
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/StatementsController/totalDataAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function total($body)
    {
        return $this->restful("POST", "/statements/total", $body);
    }

    /**
     * 新增结算单
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/StatementsController/AddAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function addStatements($body)
    {
        return $this->restful("POST", "/statements/add", $body);
    }

    /**
     * 连锁财务发起新增结算单
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/StatementsController/AddFromMerchantAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function addStatementsFromMerchant($body)
    {
        return $this->restful("POST", "/statements/AddFromMerchant", $body);
    }

    /**
     * 连锁财务对比后发起新增结算单
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/StatementsController/AddFromCompareAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function addStatementsFromCompare($body)
    {
        return $this->restful("POST", "/statements/AddFromCompare", $body);
    }

    /**
     * 结算单审核接口
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/StatementsController/auditingAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function auditingStatements($body)
    {
        return $this->restful("POST", "/statements/auditing", $body);
    }

    /**
     * 结算单状态变更接口
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/StatementsController/changeStatusAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function changeStatus($body)
    {
        return $this->restful("POST", "/statements/change/status", $body);
    }

    /**
     * 商品明细
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/GoodsController/detailAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function goodsDetails($body)
    {
        return $this->restful("POST", "/goods/details", $body);
    }

    /**
     * 商品列表
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/GoodsController/listAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function goodsList($body)
    {
        return $this->restful("POST", "/goods/list", $body);
    }

    /**
     * 订单结算明细
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/OrdersController/detailAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function ordersDetails($body)
    {
        return $this->restful("POST", "/orders/details", $body);
    }

    /**
     * 订单列表
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/OrdersController/listAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function ordersList($body)
    {
        return $this->restful("POST", "/orders/list", $body);
    }

    /**
     * 结算单结算数据支付方式
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/StatementsController/payDataAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function payStatements($body)
    {
        return $this->restful("POST", "/statements/pay", $body);
    }

    /**
     * 获取账单的操作日志
     * @link https://uniondrug.coding.net/p/union.finance/git/blob/development/docs/api/Statements/LogController/listAction.md
     * @param object|array $body 入参类型
     * @return ClientResponseInterface
     */
    public function logPaging($body)
    {
        return $this->restful("POST", "/log/paging", $body);
    }
}
