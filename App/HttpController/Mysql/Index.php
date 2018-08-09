<?php

namespace App\HttpController\Mysql;

use App\Utility\MysqlPool2;
use EasySwoole\Core\Component\Pool\PoolManager;
use EasySwoole\Core\Http\AbstractInterface\Controller;

class Index extends Controller
{
    function index()
    {
        $pool = PoolManager::getInstance()->getPool(MysqlPool2::class);
        \go(function ()use($pool){
            $db = $pool->getObj();
            if($db){
                $ret = $db->rawQuery('select sleep(1)');
                $pool->freeObj($db);
                var_dump('1 finish at '.time());
            }else{
                var_dump('db not available');
            }
        });
        \go(function ()use($pool){
            $db = $pool->getObj();
            if($db){
                $ret = $db->where('content','sgsg')->get('easyswoole');
                $pool->freeObj($db);
                print_r($ret);
                var_dump('2 finish at '.time());
            }else{
                var_dump('db not available');
            }
        });
        \go(function ()use($pool){
           $db = $pool->getObj();
           if($db){
               $ret = $db->get('easyswoole');
               $pool->freeObj($db);
               print_r($ret);
           }else{
               var_dump('db not available');
           }
        });
        $this->response()->write('request over');
    }
}