<?php

namespace App\HttpController;

use EasySwoole\Core\Http\AbstractInterface\Controller;

/**
 * Class Index
 * @package App\HttpController
 */
class Index extends Controller
{
    /**
     * 首页方法
     * @author : evalor <master@evalor.cn>
     */
    function index()
    {
	$this->response()->write('hello world!');
    }
}
