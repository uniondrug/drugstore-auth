<?php
/**
 * 基于TOKEN的认证方式。
 */
namespace Uniondrug\DrugstoreAuth;

use Phalcon\Http\RequestInterface;
use Uniondrug\Middleware\DelegateInterface;
use Uniondrug\Middleware\Middleware;
use Uniondrug\Framework\Logics\Logic;

/**
 * Class TokenAuthMiddleware
 * @package Uniondrug\TokenAuthMiddleware
 * @property \Uniondrug\DrugstoreAuth\DrugstoreAuthService $drugstoreAuthService
 */
class DrugstoreAuthLogic extends Logic
{
    private $partnerOrgan = null;
    private $storeOrgan = null;
    private $dtpStoreOrgan = null;
    private $dtpPartnerOrgan = null;
    private $commonStoreOrgan = null;
    private $commonPartnerOrgan = null;
    private $configs = null;
    const USER_CACHE = 'APP:USER_ID_';
    const NOW_STORE_CACHE = 'APP:AUTH_MERCHANT_ID_';
    const COMMON_STORE_CACHE = 'APP:COMMON_AUTH_STORE_ID_';
    const DTP_STORE_CACHE = 'APP:DTP_AUTH_STORE_ID_';

    /**
     * @param array|null|object $payload
     * @return Row|array|\Uniondrug\Structs\StructInterface
     */
    function run($payload)
    {
        $assistantId = $payload['asssistantId'];
        // 添加店员缓存
        $assistant = $this->createAssistantCache($assistantId);
        // 添加连锁缓存
        $this->createMerchantCache($assistant);
        // 获取普通门店缓存
        $this->createCommonStoreCache($assistant);
        // 获取dtp门店缓存
        $this->createDtpStoreCache($assistant);
    }

    /**
     * 没数据默认开启
     * @param $merchantConfigs
     * @param $storeConfigs
     * @param $type
     * @return int
     */
    public function getNoDataDefaultOpen($merchantConfigs, $storeConfigs, $type)
    {
        if (array_key_exists($type, $merchantConfigs)) {
            if (!$merchantConfigs[$type]['status']) {
                return 0;
            }
        }
        if (array_key_exists($type, $storeConfigs)) {
            if (!$storeConfigs[$type]['status']) {
                return 0;
            }
        }
        return 1;
    }

    /**
     * 没数据默认关闭
     * @param $merchantConfigs
     * @param $storeConfigs
     * @param $type
     * @return int
     */
    public function getNoDataDefaultClose($merchantConfigs, $storeConfigs, $type)
    {
        if (array_key_exists($type, $merchantConfigs)) {
            if (!$merchantConfigs[$type]['status']) {
                return 0;
            }
        }
        if (array_key_exists($type, $storeConfigs)) {
            if (!$storeConfigs[$type]['status']) {
                return 0;
            }
        }
        if (!array_key_exists($type, $storeConfigs) && !array_key_exists($type, $merchantConfigs)) {
            return 0;
        }
        return 1;
    }

    /**
     * 创建店员缓存
     * @param $assistantId
     * @return array|mixed\
     */
    private function createAssistantCache($assistantId)
    {
        if (!$assistant = $this->redis->get(self::USER_CACHE.$assistantId)) {
            // 1.获取用户信息
            $assistant = $this->drugstoreAuthService->assistantDetail([
                'id' => $assistantId
            ]);
            if ($assistant['status'] != DrugstoreAuthService::STATUS_NORMAL) {
                throw new Error(401, 'Forbidden: Invalid Token');
            }
            // 2.获取门店数据
            if (!$this->storeOrgan) {
                $this->initStoreCache($assistant['storeOrganId']);
            }
            $result = [
                'id' => $assistant['id'],
                'assistantMobile' => $assistant['account'],
                'assistantName' => $assistant['name'],
                'assistantRole' => $assistant['role'],
                'assistantIdCard' => $assistant['idCard'],
                'assistantJobNumber' => $assistant['jobNumber'],
                'memberId' => $assistant['memberId'],
                'wxImage' => $assistant['icon'],
                'isCertification' => $assistant['isCertification'],
                'isAdviser' => $assistant['isAdviser'],
                'storeOrganId' => $assistant['storeOrganId'],
                'partnerOrganId' => $assistant['partnerOrganId'],
                'commonStoreOrganId' => $this->commonStoreOrgan['organizationId'],
                'commonPartnerOrganId' => $this->commonPartnerOrgan['organizationId'],
                'dtpStoreOrganId' => $this->dtpStoreOrgan['organizationId'],
                'dtpPartnerOrganId' => $this->dtpPartnerOrgan['organizationId'],
            ];
            $this->redis->setex(self::USER_CACHE.$assistantId, $this->config->path('drugAuth.tokenCacheTime'), json_encode($result));
        } else {
            $result = json_decode($assistant, true);
        }
        return $result;
    }

    /**
     * 获取配置缓存
     * @param $assistant
     * @throws Error
     */
    private function createMerchantCache($assistant)
    {
        if (!$this->redis->get(self::NOW_STORE_CACHE.$assistant['storeOrganId'])) {
            if (!$this->storeOrgan) {
                $this->initStoreCache($assistant['storeOrganId']);
            }
            // 获取连锁配置
            $merchantConfigs = array_column($this->configs['partnerConfig'], null, 'type');
            // 获取门店配置
            $storeConfigs = array_column($this->configs['storeConfig'], null, 'type');
            $data = [
                'merchantSecond' => $this->getNoDataDefaultClose($merchantConfigs, $storeConfigs, UdappService::MERCHANT_SECOND),
                'memberPay' => $this->getNoDataDefaultClose($merchantConfigs, $storeConfigs, UdappService::MEMBER_PAY),
                'assistantWechatPay' => $this->getNoDataDefaultClose($merchantConfigs, $storeConfigs, UdappService::ASSISTANT_WECHAT_PAY),
                'assistantAliPay' => $this->getNoDataDefaultClose($merchantConfigs, $storeConfigs, UdappService::ASSISTANT_APLI_PAY),
                'erpPay' => $this->getNoDataDefaultClose($merchantConfigs, $storeConfigs, UdappService::ERP_PAY),
                'qrcodePay' => $this->getNoDataDefaultClose($merchantConfigs, $storeConfigs, UdappService::QRCODE_PAY),
                'directChange' => $this->partnerOrgan['infoRmation']['isDirectRenewal'],
                'isDirect' => $this->partnerOrgan['infoRmation']['isDirectPay'],
                'prescriptionSystem' => $this->partnerOrgan['isElectronic'],
                'insurancePayMethod' => $this->getNoDataDefaultClose($merchantConfigs, $storeConfigs, UdappService::INSURANCE_PAY_METHOD),
                'assistantGrow' => $this->getNoDataDefaultClose($merchantConfigs, $storeConfigs, UdappService::ASSISTANT_GROW),
                'isUseProductCenter' => $this->getNoDataDefaultClose($merchantConfigs, $storeConfigs, UdappService::IS_USE_PRODUCT_CENTER),
                'openNewOrderProcess' => $this->getNoDataDefaultClose($merchantConfigs,$storeConfigs,UdappService::OPEN_NEW_ORDER_PROCESS),
                'partnerOrganId' => $this->partnerOrgan['organizationId'],
                'partnerName' => $this->partnerOrgan['name'],
                'partnerShortName' => $this->partnerOrgan['shortName'],
                'partnerInternalCode' => $this->partnerOrgan['internalCode'],
                'partnerCooperCode' => $this->partnerOrgan['cooperationCode'],
                'partnerStatus' => $this->partnerOrgan['status'],
                'storeOrganId' => $this->storeOrgan['organizationId'],
                'storeName' => $this->storeOrgan['name'] ?: '',
                'storeShortName' => $this->storeOrgan['shortName'] ?: '',
                'storeInternalCode' => $this->storeOrgan['internalCode'] ?: '',
                'storeCooperCode' => $this->storeOrgan['cooperationCode'],
                'storeStatus' => $this->storeOrgan['status'],
                'storeIsWholesale' => array_key_exists('isWholesale', $this->partnerOrgan) ? $this->partnerOrgan['isWholesale'] : 0
            ];
            $this->redis->setex(self::NOW_STORE_CACHE.$assistant['storeOrganId'], $this->config->path('drugAuth.tokenCacheTime'), json_encode($data));
        }
    }


    /**
     * 创建普通门店缓存数据
     * @param $assistant
     * @throws Error
     */
    private function createCommonStoreCache($assistant)
    {
        if (array_key_exists('commonStoreOrganId', $assistant) && $assistant['commonStoreOrganId']) {
            if (!$this->redis->get(self::COMMON_STORE_CACHE.$assistant['commonStoreOrganId'])) {
                if (!$this->storeOrgan) {
                    $this->initStoreCache($assistant['storeOrganId']);
                }
                $result = [
                    'partnerOrganId' => $this->commonPartnerOrgan['organizationId'],
                    'partnerName' => $this->commonPartnerOrgan['name'],
                    'partnerShortName' => $this->commonPartnerOrgan['shortName'],
                    'partnerInternalCode' => $this->commonPartnerOrgan['internalCode'],
                    'partnerCooperCode' => $this->commonPartnerOrgan['cooperationCode'],
                    'storeOrganId' => $this->commonStoreOrgan['organizationId'],
                    'storeName' => $this->commonStoreOrgan['name'],
                    'storeShortName' => $this->commonStoreOrgan['shortName'],
                    'storeInternalCode' => $this->commonStoreOrgan['internalCode'],
                    'storeCooperCode' => $this->commonStoreOrgan['cooperationCode'],
                    'directChange' => $this->commonPartnerOrgan['infoRmation']['isDirectRenewal']
                ];
                $this->redis->setex(self::COMMON_STORE_CACHE.$assistant['commonStoreOrganId'], $this->config->path('drugAuth.tokenCacheTime'), json_encode($result));
            }
        }
    }

    /**
     * 创建dtp门店缓存
     * @param $assistant
     * @throws Error
     */
    private function createDtpStoreCache($assistant)
    {
        if (array_key_exists('dtpStoreOrganId', $assistant) && $assistant['dtpStoreOrganId']) {
            if (!$this->redis->get(self::DTP_STORE_CACHE.$assistant['dtpStoreOrganId'])) {
                if (!$this->storeOrgan) {
                    $this->initStoreCache($assistant['storeOrganId']);
                }
                $result = [
                    'partnerOrganId' => $this->dtpPartnerOrgan['organizationId'],
                    'partnerName' => $this->dtpPartnerOrgan['name'],
                    'partnerShortName' => $this->dtpPartnerOrgan['shortName'],
                    'partnerInternalCode' => $this->dtpPartnerOrgan['internalCode'],
                    'partnerCooperCode' => $this->dtpPartnerOrgan['cooperationCode'],
                    'storeOrganId' => $this->dtpStoreOrgan['organizationId'],
                    'storeName' => $this->dtpStoreOrgan['name'],
                    'storeShortName' => $this->dtpStoreOrgan['shortName'],
                    'storeInternalCode' => $this->dtpStoreOrgan['internalCode'],
                    'storeCooperCode' => $this->dtpStoreOrgan['cooperationCode'],
                    'directChange' => $this->dtpPartnerOrgan['infoRmation']['isDirectRenewal']
                ];
                $this->redis->setex(self::DTP_STORE_CACHE.$assistant['dtpStoreOrganId'], $this->config->path('drugAuth.tokenCacheTime'), json_encode($result));
            }
        }
    }

    /**
     * 初始化门店数据
     * @param $storeOrganId
     * @throws Error
     */
    private function initStoreCache($storeOrganId)
    {
        // 门店信息
        $this->storeOrgan = $this->drugstoreAuthService->getByOrganId($storeOrganId);
        // 连锁信息
        $this->partnerOrgan = $this->drugstoreAuthService->getByOrganId($this->storeOrgan['rootId']);
        $this->configs = $this->drugstoreAuthService->configStatus([
            'partnerOrganId' => $this->storeOrgan['rootId'],
            'storeOrganId' => $this->storeOrgan['organizationId']
        ]);
        // 判断是不是dtp门店 2 dtp门店 1 社会门店
        if ($this->storeOrgan['netType'] == 2) {
            $this->dtpStoreOrgan = $this->storeOrgan;
            $this->dtpPartnerOrgan = $this->partnerOrgan;
            // 判断是否关联社会门店
            if ($this->storeOrgan['societyVelationId']) {
                $this->commonStoreOrgan = $this->drugstoreAuthService->getByOrganId($this->storeOrgan['societyVelationId']);
                $this->commonPartnerOrgan = $this->drugstoreAuthService->getByOrganId($this->commonStoreOrgan['rootId']);
            }
        } else {
            $this->commonStoreOrgan = $this->storeOrgan;
            $this->commonPartnerOrgan = $this->partnerOrgan;
            // 判断是否关联dtp门店
            if ($this->storeOrgan['DTPVelationId']) {
                $this->dtpStoreOrgan = $this->drugstoreAuthService->getByOrganId($this->storeOrgan['DTPVelationId']);
                $this->dtpPartnerOrgan = $this->drugstoreAuthService->getByOrganId($this->dtpStoreOrgan['rootId']);
            }
        }
    }
}
