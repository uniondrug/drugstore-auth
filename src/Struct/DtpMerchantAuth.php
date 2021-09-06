<?php
/**
 * Created by PhpStorm.
 * User: lvchaohui
 * Date: 2020/10/22
 * Time: 2:42 PM
 */
namespace Uniondrug\DrugstoreAuth\Struct;

use Uniondrug\Structs\Struct;

/**
 * Class DtpMerchantAuth
 * @package App\Structs\Results\Merchant
 */
class  DtpMerchantAuth extends Struct
{
    /**
     * 自付带换新配置
     * @var int
     */
    public $directChange;
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
}