<?php
namespace app\admin\controller;
use think\Controller;
use think\Request;
use think\Db;
use app\admin\model\Users;
use think\Session;

class Login extends Controller
{
	public function test()
	{
		return view();
	
	}
	public function index()
	{
		//return 'logo';
		return view();
	}
	public function signin()
	{
		return view();
	}
	
	
	//增加用户   测试ok 暂时没有md5
	public function addUser()
	{
		//使用此方法，注意在html中的input标签的name属性需要跟users表中的字段一致
		$data=input('post.');
		$users=new Users;
		if($users->allowField(true)->save($data))
		{
			return '增加成功！';
		}
		else
		{
			return '增加失败';
		}
		
	}
}
