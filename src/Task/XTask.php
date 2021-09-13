<?php
/**
 * Created by PhpStorm.
 * User: lvchaohui
 * Date: 2021/9/13
 * Time: 6:31 PM
 */
namespace Uniondrug\DrugstoreAuth\Task;

use App\Services\Abstracts\ServiceTrait;
use Uniondrug\Phar\Server\Tasks\XTask as Task;
use Uniondrug\Framework\Services\ServiceTrait as UnionDrugServiceTrait;
use Phalcon\Config;
use Uniondrug\Redis\Client;

/**
 * Class XTask
 * @package App\Tasks\Abstracts
 */
abstract class XTask extends Task
{
    /**
     * 导入IDE定义
     * 1. property
     * 2. method
     */
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
     * 前置任务
     * 仅当返回true时, 继续调用run()方法, 反之, 跳出任务
     * 不做任务处理, 其中run(), afterRun()都不会触发
     * @return bool
     */
    public function beforeRun()
    {
        // 检查mysql
        $this->checkMysql();
        // 检查redis
        $this->checkRedis();
        return true;
    }
}
