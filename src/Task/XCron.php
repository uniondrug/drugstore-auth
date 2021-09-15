<?php
/**
 * Created by PhpStorm.
 * User: lvchaohui
 * Date: 2021/8/26
 * Time: 5:25 PM
 */
namespace Uniondrug\DrugstoreAuth\Task;

use Uniondrug\Framework\Services\ServiceTrait as UnionDrugServiceTrait;
use App\Services\Abstracts\ServiceTrait;
use Uniondrug\Redis\Client;
use Phalcon\Config;

/**
 * 定时任务基类
 * 定时任务XCron为异步任务XTask的一种特殊行式, 不同点再于定时任务由
 * PharProcess进程触发, 同时不含任何参数, 而异步任务由业务代码调用
 * runTask()方法投递, 投递时接受数组参数
 * @package Uniondrug\Phar\Server\Tasks
 */
abstract class XCron extends \Uniondrug\Phar\Server\Tasks\XCron
{
    use ServiceTrait;
    use UnionDrugServiceTrait;

    /**
     * 检查mysql是否连接
     */
    private function checkMysql()
    {
        if ($this->config->path('database')) {
            try {
                $this->db->query("SELECT 1");
            } catch(\Throwable $e) {
                $this->db->connect();
            }
        }
    }

    /**
     * 检查redis是否连接
     */
    private function checkRedis()
    {
        if ($this->config->path('redis')) {
            try {
                $this->redis->ping();
            } catch(\Throwable $e) {
                $config = $this->config->path('redis');
                // 1. Redis对象
                $optConfig = isset($config->options) && $config->options instanceof Config ? $config->options->toArray() : $config->toArray();
                $this->redis = new Client($optConfig);
            }
        }
    }

    /**
     * 检查重复
     * @return bool
     */
    private function checkRepeat()
    {
        $className = get_called_class();
        $projectName = $this->config->path('app')->appName;
        $key = 'APP:'.$projectName.':'.$className;
        $value = $this->redis->getSet($key, 1);
        $this->redis->expire($key, 3);
        if ($value) {
            return true;
        }
        return false;
    }

    /**
     * 前置任务
     * 仅当返回true时, 继续调用run()方法, 反之, 跳出任务
     * 不做任务处理, 其中run(), afterRun()都不会触发
     * @return bool
     */
    public function beforeRun()
    {
        // 检查重复性
        if ($this->checkRepeat()) {
            return false;
        }
        // 检查mysql
        $this->checkMysql();
        // 检查redis
        $this->checkRedis();
        return true;
    }
}