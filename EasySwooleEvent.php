<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/1/9
 * Time: 下午1:04
 */

namespace EasySwoole;

use App\Utility\MysqlPool2;
use App\Utility\RedisPool;
use \EasySwoole\Core\AbstractInterface\EventInterface;
use EasySwoole\Core\Component\Pool\PoolManager;
use \EasySwoole\Core\Swoole\ServerManager;
use \EasySwoole\Core\Swoole\EventRegister;
use \EasySwoole\Core\Http\Request;
use \EasySwoole\Core\Http\Response;
// 引入EventHelper
use \EasySwoole\Core\Swoole\EventHelper;
// 注意这里是指额外引入我们上文实现的解析器
use \App\WebSocket\Parser as WebSocketParser;

Class EasySwooleEvent implements EventInterface {

    public static function frameInitialize(): void
    {
        // TODO: Implement frameInitialize() method.
        date_default_timezone_set('Asia/Shanghai');
    }

    public static function mainServerCreate(ServerManager $server,EventRegister $register): void
    {
        // TODO: Implement mainServerCreate() method.

        // Mysql协程连接池 and Redis协程连接池
        if (version_compare(phpversion('swoole'), '2.1.0', '>=')) {
            PoolManager::getInstance()->registerPool(MysqlPool2::class, 3, 10);
            PoolManager::getInstance()->registerPool(RedisPool::class, 3, 10);
        }

        // 注意一个事件方法中可以注册多个服务，这里只是注册WebSocket解析器
        // // 注册WebSocket处理
        EventHelper::registerDefaultOnMessage($register, WebSocketParser::class);

    }

    public static function onRequest(Request $request,Response $response): void
    {
        // TODO: Implement onRequest() method.
    }

    public static function afterAction(Request $request,Response $response): void
    {
        // TODO: Implement afterAction() method.
    }
}