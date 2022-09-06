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
 * 云图服务
 * @package Uniondrug\ServiceSdk\Modules
 */
class MapSdk extends Sdk implements ServiceSdkInterface
{
    protected $serviceName = 'map';

    /**
     * 注册新应用
     * @link https://uniondrug.coding.net/p/module.map/git/blob/development/docs/api/AmapController/searchAction.md
     * @param array|StructInterface $body
     * @return ClientResponseInterface
     */
    public function amapSearch($body)
    {
        return $this->restful(static::METHOD_POST, "/amap/search", $body);
    }

    /**
     * 创建地图打点
     * @link https://uniondrug.coding.net/p/module.map/git/blob/development/docs/api/AmapController/searchAction.md
     * @param array|StructInterface $body
     * @return ClientResponseInterface
     */
    public function createAmap($body)
    {
        return $this->restful(static::METHOD_POST, "/amap/data/create", $body);
    }


    /**
     * 读取数据POSTphp
     * @link https://uniondrug.coding.net/p/module.map/git/blob/development/docs/api/AMapController/infoAction.md
     * @param array|StructInterface $body
     * @return ClientResponseInterface
     */
    public function infoAmap($body)
    {
        return $this->restful("POST", "/amap/data/info", $body);
    }

    /**
     * 删除数据，删除后可以重新创建
     * 输入：
     * ids，待删除的id，可以是数组，不超过50个。
     * @link https://uniondrug.coding.net/p/module.map/git/blob/development/docs/api/AMapController/deleteAction.md
     * @param array|StructInterface $body
     * @return ClientResponseInterface
     */
    public function deleteAmap($body)
    {
        return $this->restful("POST", "/amap/data/delete", $body);
    }

    /**
     * 修改链接
     * @link https://uniondrug.coding.net/p/module.map/git/blob/development/docs/api/AmapController/searchAction.md
     * @param array|StructInterface $body
     * @return ClientResponseInterface
     */
    public function updateMap($body)
    {
        return $this->restful(static::METHOD_POST, "/amap/data/update", $body);
    }

    /**
     * 经纬度转换
     * @link https://uniondrug.coding.net/p/module.map/git/blob/development/docs/api/Location/ConvertController/convertAction.md
     * @param array|StructInterface $body
     * @return ClientResponseInterface
     */
    public function locationConvert($body)
    {
        return $this->restful(static::METHOD_POST, "/location/convert", $body);
    }

    /**
     * 经纬度详情
     * @link https://uniondrug.coding.net/p/module.map/git/blob/development/docs/api/Location/DetailController/detailAction.md
     * @param array|StructInterface $body
     * @return ClientResponseInterface
     */
    public function locationDetail($body)
    {
        return $this->restful(static::METHOD_POST, "/location/detail", $body);
    }

    /**
     * 地址转为经纬度
     * @link https://uniondrug.coding.net/p/module.map/git/blob/development/docs/api/Location/ByAddressController/byAddressAction.md
     * @param array|StructInterface $body
     * @return ClientResponseInterface
     */
    public function locationByAddress($body)
    {
        return $this->restful(static::METHOD_POST, "/location/byAddress", $body);
    }

    /**
     * 行政区域查询
     * @link https://uniondrug.coding.net/p/module.map/git/blob/development/docs/api/District/ByKeywordsController/byKeywordsAction.md
     * @param array|StructInterface $body
     * @return ClientResponseInterface
     */
    public function districtByKeywords($body)
    {
        return $this->restful(static::METHOD_POST, "/district/byKeyword", $body);
    }

    /**
     * 获取两经纬度距离
     * @link https://uniondrug.coding.net/p/module.map/git/blob/development/docs/api/Location/GetDistanceController/distanceAction.md
     * @param array|StructInterface $body
     * @return ClientResponseInterface
     */
    public function locationDistance($body)
    {
        return $this->restful(static::METHOD_POST, "/location/distance", $body);
    }

    /**
     * 获取城市天气情况
     * @link https://uniondrug.coding.net/p/module.map/d/module.map/git/blob/development/docs/api/Location/WeatherController/byCityAction.md
     * @param array $body 入参类型
     * @return ResponseInterface
     */
    public function cityWeather($body)
    {
        return $this->restful(static::METHOD_POST, "/location/weather", $body);
    }
}
