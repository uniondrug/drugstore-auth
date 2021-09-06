<?php
/**
 * Created by PhpStorm.
 * User: lvchaohui
 * Date: 2019/11/24
 * Time: 5:38 PM
 */
namespace Uniondrug\DrugstoreAuth\Struct;

use Uniondrug\Structs\Struct;

/**
 * Class MerchantAuth
 * @package App\Structs\Results\Merchant
 */
class MerchantAuth extends Struct
{
    /**
     * 二次扫码配置
     * @var int
     */
    public $merchantSecond;
    /**
     * 用户自付配置
     * @var int
     */
    public $memberPay;
    /**
     * 店员微信支付配置
     * @var int
     */
    public $assistantWechatPay;
    /**
     * 店员阿里支付配置
     * @var int
     */
    public $assistantAliPay;
    /**
     * erp支付配置
     * @var int
     */
    public $erpPay;
    /**
     * 二维码扫码配置
     * @var int
     */
    public $qrcodePay;
    /**
     * 二维码扫码配置
     * @var int
     */
    public $assistantGrow;
    /**
     * 是否使用商户中心的药品搜索接口
     * @var int
     */
    public $isUseProductCenter;
    /**
     * 自付带换新配置
     * @var int
     */
    public $directChange;
    /**
     * 是否开启直付
     * @var int
     */
    public $isDirect;
    /**
     * 处方配置
     * @var int
     */
    public $prescriptionSystem;
    /**
     * 商保二维码
     * @var int
     */
    public $insurancePayMethod;
    /**
     * 连锁id
     * @var int
     */
    public $partnerOrganId;
    /**
     * 连锁名称
     * @var string
     */
    public $partnerName;
    /**
     * 短名称
     * @var string
     */
    public $partnerShortName;
    /**
     * 编号
     * @var string
     */
    public $partnerInternalCode;
    /**
     * 连锁状态
     * @var int
     */
    public $partnerStatus;
    /**
     * 门店id
     * @var int
     */
    public $storeOrganId;
    /**
     * 名称
     * @var string
     */
    public $storeName;
    /**
     * 短名称
     * @var string
     */
    public $storeShortName;
    /**
     * @var string
     */
    public $partnerCooperCode;
    /**
     * 编号
     * @var string
     */
    public $storeInternalCode;
    /**
     * 编号
     * @var string
     */
    public $storeCooperCode;
    /**
     * 门店状态
     * @var int
     */
    public $storeStatus;
    /**
     * 是否是村医
     * @var int
     */
    public $storeIsWholesale;
    /**
     * 是否开启新流程
     * @var int
     */
    public $openNewOrderProcess;
}