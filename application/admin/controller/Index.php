<?php
namespace app\admin\controller;
use think\Controller;  //手动添加
use think\Request;
use think\Db;
class Index extends Controller
{
    public function index($name='张三')
    {
        //print_r($this->request->param());  
        //exit;
        
        $data=Db::name('user')->find();
        //var_dump($data);
        //print_r($data);
        $this->assign('da',$data);  //assign 保存变量
        $this->assign('name',$name);
        return $this->fetch();         //在静态页面显示变量数据         还可以fetch(‘xxx.html’)
        
    }
    public function hello($name="world")
    {
    	echo'hello, '.$name;
    }
    public function hello1()
    {
    	echo url();  //获取url地址
    	echo'<br>';
    	echo url('url2','a=1&b=2');
    }
    public function hello2()
    {
    	$request=Request::instance();  //如果没有继承控制器 可以使用当前和下一行 访问
    	echo $request->url();  //获取当前url地址  不含域名
    	echo '<br/>';
    	echo $this->request->url();  //获取当前url地址  不含域名
    	echo '<br/>';
    	echo $this->request->bind('user_name','张三');  //动态绑定属性
    	echo $this->request->user_name;  //其他控制器可以直接使用
    	echo '<br/>';
    	echo request()->url(); //为了简洁 方便使用 函数助手
    	print_r(input());
    }
}
