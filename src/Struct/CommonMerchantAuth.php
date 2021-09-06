<?php
/**
 * Created by PhpStorm.
 * User: lvchaohui
 * Date: 2020/10/22
 * Time: 2:41 PM
 */
namespace Uniondrug\DrugstoreAuth\Struct;

use Uniondrug\Structs\Struct;

/**
 * Class CommonMerchantAuth
 * @package App\Structs\Results\Merchant
 */
class  CommonMerchantAuth extends Struct
{
    /**
     * 门店id
     * @var int
     */
    public $storeOrganId;
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
     * 自付带换新配置
     * @var int
     */
    public $directChange;
}