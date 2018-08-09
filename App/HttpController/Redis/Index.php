<?php

namespace App\HttpController\Redis;

use App\Utility\RedisPool;
use EasySwoole\Core\Component\Pool\PoolManager;
use EasySwoole\Core\Http\AbstractInterface\Controller;
use App\Server\Redis;

class Index extends Controller{

    function index()
    {
        $connect = new Redis();
        $redis = $connect->getConnect();
        for($i=0;$i<=50;$i++){
            try{
                $redis->rPush('click',$i);//队列
            }catch(\Exception $e){
                var_dump($e);
            }
        }
        var_dump($redis->lrange('click',0,50));//打印刚存进redis的队列
    }
    function pop()
    {
        try{
            $connect = new Redis();
            $redis = $connect->getConnect();
            $value = $redis->lpop('click');
            var_dump($value);
        }catch(\Exception $e){
            var_dump($e);
        }
    }

    /*
     * 异步redis
     */
    function sysRedis(){
        $pool = PoolManager::getInstance()->getPool(RedisPool::class);
        \go(function ()use($pool){
            $redis = $pool->getObj();
            if($redis){
                $redis->exec('set','a','123');
                $a = $redis->exec('get','a');
                $pool->freeObj($redis);
                var_dump($a);
            }else{
                var_dump('redis not available');
            }
        });
        \go(function ()use($pool){
            $redis = $pool->getObj();
            if($redis){
                $redis->exec('set','b','456');
                $a = $redis->exec('get','b');
                $pool->freeObj($redis);
                var_dump($a);
            }else{
                var_dump('redis not available');
            }
        });
    }

}