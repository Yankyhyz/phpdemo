<?php
namespace app\index\controller;
use think\Controller;  //手动添加
use think\Request;
use think\Db;
class Index extends Controller
{
    public function index()
    {
        return 'hello world';
    }
    
    public function index2()
    {
        return 'index模块下的index控制器的index2方法';
    }
    
     public function index3($name='张三')
    {
    	echo $name;
        return '<br><br>index模块下的index控制器的index3方法<br>可通过地址栏传递参数<br>
        	如地址栏输入：  http://www.tp5.com/index/index/index3?name=11<br>
        		http://www.tp5.com/index/index/index3/name/12';
        	
    }
}
