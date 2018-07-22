<?php
namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\UserModel;

//定义最终的用户控制器类，并继承基础控制器类
final class UserController extends BaseController
{
	//显示后台首页
	public function index()
	{
    // //用户权限验证
    // $this->denyAccess();
		$this->smarty->show("index");
  }
  
  //显示用户列表
  public function list(){
    //获取用户列表数据
    $users = UserModel::getInstance()->fetchAll();
		//获取用户总数量
		$where = 'role=0';
    $result = UserModel::getInstance()->rowCount($where);
		//向视图赋值，并显示视图文件
    $this->smarty->assign("users",$users);
    $this->smarty->assign("result",$result);
    $this->smarty->show("list");
  }

	//显示管理员列表
	public function adminlist(){
		//获取管理员列表数据
		$arrs = UserModel::getInstance()->fetchAll();
		//获取用户总数量
		$where = 'role=1';
		$result = UserModel::getInstance()->rowCount($where);
		//向视图赋值，并显示视图文件
		$this->smarty->assign("arrs",$arrs);
		$this->smarty->assign("result",$result);
		$this->smarty->show("adminlist");
	}
	//显示添加的视图文件
	public function add()
	{
    // //用户权限验证
    // $this->denyAccess();
		$this->smarty->show("add");
	}
	
	//显示添加管理员文件视图
	public function adminadd(){
		$this->smarty->show("adminadd");
	}
  
	//插入数据
	public function insert()
	{
    // //用户权限验证
    // $this->denyAccess();
		//获取表单提交数据
    $data['username']	   = $_POST['user-name'];
    $data['password']    = $_POST['user-password'];
		$data['name']		     = $_POST['user-realname'];
		$data['tel']	       = $_POST['user-tel'];
    $data['addate']		   = time();
  
		//判断两次密码是否一致
		if($_POST['user-password']!=$_POST['user-confirmpwd'])
		{
			$this->jump("两次输入的密码不一致！","?c=User&a=add");
		}
		$data['password']	= md5($_POST['user-password']);

		//判断用户名是否唯一
		if(UserModel::getInstance()->rowCount("username='{$data['username']}'"))
		{
			$this->jump("用户名{$data['username']}已被注册啦！","?c=User&a=add");
		}

		//判断用户是否注册成功
		if(UserModel::getInstance()->insert($data))
		{
			$this->jump("用户名{$data['username']}注册成功！","?c=User&a=list");
		}else
		{
			$this->jump("用户名{$data['username']}注册失败！","?c=User&a=list");
		}
	}

	//插入管理员数据
	public function admininsert()
	{
    // //用户权限验证
    // $this->denyAccess();
		//获取表单提交数据
    $data['username']	   = $_POST['user-name'];
    $data['password']    = $_POST['user-password'];
		$data['name']		     = $_POST['user-realname'];
		$data['tel']	       = $_POST['user-tel'];
		$data['role']				 = 1;
		$data['addate']		   = time();
  
		//判断两次密码是否一致
		if($_POST['user-password']!=$_POST['user-confirmpwd'])
		{
			$this->jump("两次输入的密码不一致！","?c=User&a=adminadd");
		}
		$data['password']	= md5($_POST['user-password']);

		//判断用户名是否唯一
		if(UserModel::getInstance()->rowCount("username='{$data['username']}'"))
		{
			$this->jump("用户名{$data['username']}已被注册啦！","?c=User&a=adminadd");
		}

		//判断用户是否注册成功
		if(UserModel::getInstance()->insert($data))
		{
			$this->jump("用户名{$data['username']}注册成功！","?c=User&a=adminlist");
		}else
		{
			$this->jump("用户名{$data['username']}注册失败！","?c=User&a=adminlist");
		}
	}

	//公共的禁止用户的方法
	public function banned(){
		$id = $_GET['id'];
		$data = UserModel::getInstance()->fetchOne("id={$id}");
		if($data['status'] == 1){
			$data['status'] = 0;
			if(UserModel::getInstance()->update($data,$id)){
				if($data['role'] == 0){
					$this->jump("用户已被禁止","?c=User&a=list");
				}
				else{
					$this->jump("管理员已被禁止","?c=User&a=adminlist");
				}
			}
			else{
				if($data['role'] == 0){
					$this->jump("用户禁止失败！","?c=User&a=list");
				}
				else{
					$this->jump("管理员禁止失败","?c=User&a=adminlist");
				}
			}
		}
		else{
			$data['status'] = 1;
			if(UserModel::getInstance()->update($data,$id)){
				if($data['role'] == 0){
					$this->jump("用户已启用","?c=User&a=list");
				}
				else{
					$this->jump("管理员已启用","?c=User&a=adminlist");
				}
			}
			else{
				if($data['role'] == 0){
					$this->jump("用户启用失败！","?c=User&a=list");
				}
				else{
					$this->jump("管理员启用失败","?c=User&a=adminlist");
				}
			}
		}	
	}

	//显示修改的表单
	public function edit()
	{
    // //用户权限验证
    // $this->denyAccess();
		//获取地址栏传递的id
		$id = $_GET['id'];
		//获取指定ID的数据
		$user = UserModel::getInstance()->fetchOne("id={$id}");
		//向视图赋值，并显示视图
		$this->smarty->assign("user",$user);
		$this->smarty->show("edit");
	}

	//更新用户数据
	public function update()
	{
    // //用户权限验证
    // $this->denyAccess();
		//获取表单提交值
		$id  						= $_POST['id'];
		$data['name']		= $_POST['user-realname'];
		$data['tel']		= $_POST['user-tel'];
		
		//判断密码是否为空
		if(!empty($_POST['password']) && !empty($_POST['confirmpwd']))
		{
			//判断两次密码是否一致
			if($_POST['password']==$_POST['confirmpwd'])
			{
				$data['password'] = md5($_POST['password']);
			}else
			{
				$this->jump("两次输入的密码不一致！","?c=User&a=edit&id={$id}");
			}
		}

		//判断记录是否更新成功
		if(UserModel::getInstance()->update($data,$id))
		{
			$this->jump("的用户更新成功！","?c=User&a=list");
		}else
		{
			$this->jump("的用户更新失败！","?c=User&a=list");
		}
	}
	
	//显示修改管理员的表单
	public function adminedit()
	{
    // //用户权限验证
    // $this->denyAccess();
		//获取地址栏传递的id
		$id = $_GET['id'];
		//获取指定ID的数据
		$user = UserModel::getInstance()->fetchOne("id={$id}");
		//向视图赋值，并显示视图
		$this->smarty->assign("user",$user);
		$this->smarty->show("adminedit");
	}

	//更新管理员数据
	public function adminupdate()
	{
    // //用户权限验证
    // $this->denyAccess();
		//获取表单提交值
		$id  						= $_POST['id'];
		$data['name']		= $_POST['user-realname'];
		$data['tel']		= $_POST['user-tel'];
		
		//判断密码是否为空
		if(!empty($_POST['password']) && !empty($_POST['confirmpwd']))
		{
			//判断两次密码是否一致
			if($_POST['password']==$_POST['confirmpwd'])
			{
				$data['password'] = md5($_POST['password']);
			}else
			{
				$this->jump("两次输入的密码不一致！","?c=User&a=adminedit&id={$id}");
			}
		}

		//判断记录是否更新成功
		if(UserModel::getInstance()->update($data,$id))
		{
			$this->jump("的用户更新成功！","?c=User&a=list");
		}else
		{
			$this->jump("的用户更新失败！","?c=User&a=list");
		}
	}
	
	//删除用户
	public function delete()
	{
    // //用户权限验证
    // $this->denyAccess();
		//获取地址栏传递的ID
		$id = $_GET['id'];
		$arr = UserModel::getInstance()->fetchOne("id={$id}");
		//判断用户是否删除成功
		if(UserModel::getInstance()->delete($id))
		{
			if($arr['role']==0){
				$this->jump("用户删除成功！","?c=User&a=list");
			}
			else{
				$this->jump("管理员删除成功！","?c=User&a=adminlist");
			}
		}else
		{
			if($arr['role']==0){
				$this->jump("用户删除失败！","?c=User&a=list");
			}
			else{
				$this->jump("管理员删除失败！","?c=User&a=adminlist");
			}
		}
	}

	//显示用户登录视图
	public function login()
	{
		$this->smarty->show("login");
	}

	//用户登录处理
	public function loginCheck()
	{

		//获取表单提交值
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$verify	  = $_POST['verify'];
		//判断验证码是否正确
		if(strtolower($verify)!=strtolower($_SESSION['captcha']))
		{
			$this->jump("两次验证码不一样！","?c=User&a=login");
		}
		//判断用户名和密码是否正确
		$user = UserModel::getInstance()->fetchOne("username='$username' and password='$password'");
		if(!$user)
		{
			$this->jump("用户名或密码不正确！","?c=User&a=login");
		}
		if($user['role']!=1){
			$this->jump("对不起，普通用户无权进入后台系统","?c=User&a=login");
		}
		//更新用户资料
		$data['last_login_ip'] = $_SERVER['REMOTE_ADDR'];
		$data['last_login_time'] = time();
		$data['login_times'] = $user['login_times']+1;
		if(!UserModel::getInstance()->update($data,$user['id']))
		{
			$this->jump("用户名为{$username}更新失败！","?c=User&a=login");
		}
		//将用户状态存入SESSION
		$_SESSION['uid'] = $user['id'];
		$_SESSION['username'] = $username;

		//跳转后台管理首页
		header("location:admin.php");
	}

	//公共的验证码的方法
	public function captcha()
	{
		//创建验证码类的对象
		$captcha = new \Frame\Vendor\Captcha();
		//获取验证码字符，并保存到SESSION中
		$_SESSION['captcha'] = $captcha->getCode();
	}
}