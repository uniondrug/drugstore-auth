<?php
/**
 * Created by PhpStorm.
 * User: lvchaohui
 * Date: 2019/10/26
 * Time: 12:12 PM
 */
namespace Uniondrug\DrugstoreAuth\Struct;

use App\Structs\Traits\TokenTrait;
use Uniondrug\Structs\PagingRequest;
use Uniondrug\Structs\Struct;

/**
 * Class User
 * @package App\Structs\Requests\User
 */
class User extends Struct
{
    /**
     * @var int
     */
    public $id;
    /**
     * 手机号
     * @var string
     */
    public $assistantMobile;
    /**
     * 手机名称
     * @var string
     */
    public $assistantName;
    /**
     * 权限
     * 身份 0 其它  1 店长  2 店员
     * @var int
     */
    public $assistantRole;
    /**
     * 工号
     * @var string
     */
    public $assistantJobNumber;
    /**
     * 身份证
     * @var string
     */
    public $assistantIdCard;
    /**
     * 用户id
     * @var int
     */
    public $memberId;
    /**
     * 图表
     * @var string
     */
    public $wxImage;
    /**
     * 是否实名
     * @var int
     */
    public $isCertification;
    /**
     * 是否是医师
     * @var int
     */
    public $isPharmacist;
    /**
     * 医师状态
     * @var int
     */
    public $pharmacistStatus;
    /**
     * 是否是顾问
     * @var int
     */
    public $isAdviser;
    /**
     * 连锁id
     * @var int
     */
    public $partnerOrganId;
    /**
     * 门店id
     * @var int
     */
    public $storeOrganId;
    /**
     * 社会门店id
     * @var int
     */
    public $commonStoreOrganId;
    /**
     * 社会连锁id
     * @var int
     */
    public $commonPartnerOrganId;
    /**
     * dtp门店id
     * @var int
     */
    public $dtpStoreOrganId;
    /**
     * dtp连锁id
     * @var int
     */
    public $dtpPartnerOrganId;
}