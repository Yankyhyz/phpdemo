<?php
namespace app\admin\controller;
use think\Controller;  //手动添加
use think\Request;
use think\Db;
use think\Session;

use app\admin\model\Data;
class Index extends Controller
{
	
	public function add()
	{
		//新增数据
	    $data  = input('post.');
        // 验证birthday是否有效的日期
        //$check = Validate::is($data['birthday'],'date');
        //if (false === $check) {
        //     return 'birthday日期格式非法';
        //}
        $users = new Data;
        // 数据保存
        $users->allowField(true)->save($data);
        return '用户[ ' . $users->id . ':' . $users->name . ' ]新增成功';
	}
	public function Login()
	{
		//提交表单
		//return $this->fetch();
		return view();
		
	}
    public function index($name='张三')
    {
        //print_r($this->request->param());  
        //exit;
        
        $data=Db::name('tp_data')->find();
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
    public function hello3()
    {
    	$data=['name'=>'thinkphp','status'=>'1'];
    	//return $data;   //不能直接输出
    	//return json($data);  //json格式输出
    	//return xml($data);   //xml格式输出
    	$this->assign('name','渲染模板');
    	//return $this->fetch('index/index'); //显示index控制器下index方法的相应html
    	return $this->fetch();  //显示当前控制器下当前方法的相应html
    }
    public function hello4()
    {
    	//页面跳转
    	//$this->success('稍等','index/index');//提示再跳转
    	//$this->error('错误','hello3');//模板位置：thinkphp->tpl->dispatch_jump.tpl
    	//$this->redirect('http://www.baidu.com'); 
        $this->redirect('hello3');//重定向，直接跳转
    }
    public function query1()
    {
    	//$result=Db::execute('insert into tp_data (id,name,status) values(1,"1111",1)');
    	//($result);
    	// $result=Db::execute('update  tp_data set name="thinkphp" where id=1');
    	//dump($result);
    	//$result=Db::query('select * from tp_data where id=1');
    	//print_r($result);
    	//$result=Db::execute('delete  from tp_data where id=1');
    	//print_r($result);
    	$result=Db::query('show tables from nanyang');//显示表结构
    	print_r($result);
    }
    public function query2()
    {
    	
    	//在config.php 配置多个数据库后可用 Db::connect方法连接
    	
    	//$result=Db::connect('db1')->query('select * from user');
    	//print_r($result);
    	
    	//参数绑定
    	//Db::execute('insert into tp_data (id, name ,status) values (?, ?, ?)', [2, 'thinkphp', 1]);
		//$result = Db::query('select * from tp_data where id = ?', [2]);
		//dump($result);
		
		
		//占位符绑定
		Db::execute('insert into tp_data (id, name , status) values (:id, :name, :status)', ['id' => 10, 'name' => 'thinkphp', 'status' => 1]);

		$result = Db::query('select * from tp_data where id=:id', ['id' => 10]);
		dump($result);
    }
    public function query3()
    {
    	//查询构造器  不需要写sql语句
        
        //插入记录
        		//Db::table('tp_data')->insert(['id'=>3,'name'=>'insert','status'=>1]);
        		//Db::name('data')->insert(['id'=>4,'name'=>'insert','status'=>1]);  //在config.php 设置了 'prefix' => 'tp_',即数据表有前缀
        	
        	//更新记录
        		//Db::table('tp_data')->where("id",3)->update(['name'=>"更新"]);
        		
		//删除记录
		//Db::table('tp_data')->where('id',3)->delete();
		
		//查询记录
		$list = Db::table('tp_data')->where('id', 10)->select();
		print_r($list);

    }
    public function query4()
    {
    	//链式操作
    	// 查询十个满足条件的数据 并按照id倒序排列
		$list = Db::name('data')
		   ->where('status', 1)
		   ->field('id,name')
		   ->order('id', 'desc')
		   ->limit(10)
		   ->select();
		dump($list);
    }
    public function query5()
    {
    	//事务支持
    	//由于需要用到事务的功能，请先修改数据表的类型为InnoDB，而不是MyISAM。
		//对于事务的支持，最简单的方法就是使用transaction方法，只需要把需要执行的事务操作封装到闭包里面即可自动完成事务，例如：
		Db::transaction(function () {
   		Db::table('tp_data')
       		->delete(1);
  		Db::table('tp_data')
       		->insert(['id' => 28,
       		 'name' => 'thinkphp',
       		  'status' => 1]
       		  );
       	});
    }
    
    public function query6()
    {
    	//快捷查询
    	//如果你有多个字段需要使用相同的查询条件，可以使用快捷查询。例如，我们要查询id和status都大于0的数据
    	$result = Db::name('data')
		    ->where('id&status', '>', 0)
		    ->limit(10)
		    ->select();
		dump($result); 
    }
    public function query7()
    {
    	//视图查询
    	//如果需要快捷查询多个表的数据，可以使用视图查询，相当于在数据库创建了一个视图，但仅仅支持查询操作
		/*$result = Db::view('user','id,name,status')    ->view('profile',['name'=>'truename','phone','email'],'profile.user_id=user.id')
		    ->where('status',1)
		    ->order('id desc')
		    ->select();*/
	//	dump($result);
    }
    
    public function model1()
    {
    	//使用模型model Data类
    	//$result=Data::get(1);
    	//print_r($result);
    	
    	//插入操作
    	//$Date=new Data;
    	//$Date->id=7;
    	//$Date->name='hello';
    	//$Date->status=1;
    	//$Date->save();
    	
    	//换种方法插入操作
    	$data['id']=12;
    	$data['name']='date';
    	$data['status']=1;
    	if($result=Data::create($data))
    	{
    		//要双引号
    		echo "id= {$result->id}";
    	}
    	
    }
}
