<?php

namespace App\HttpController\Redis;
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
}