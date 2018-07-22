<?php
namespace Frame\Libs;
// use \Frame\Vendor\Smarty;
//抽象的控制器基础类
abstract class BaseController
{
  protected $smarty = null;
  //公共的构造方法
  public function __construct()
  {
    //创建Smarty类
    $smarty = new \Frame\Vendor\Smarty();
    //配置Smarty
    $smarty->setLeftDelimiter("<{");
    $smarty->setRightDelimiter("}>");
    $smarty->setTemplateDir(VIEW_PATH);
    $smarty->setCompileDir(sys_get_temp_dir() . DS . "view_c" . DS);
    $this->smarty = $smarty;
  } 

  //受保护的用户权限验证的方法
  protected function denyAccess()
  {
		//判断用户是否登录
    if (!isset($_SESSION['username'])) {
      $this->jump("你还没有登录！", "?c=User&a=login");
    }
  }

	//受保护的跳转方法
  protected function jump($message, $url = "?", $time = 3)
  {
		//向视图赋值
    $this->smarty->assign("message", $message);
    $this->smarty->assign("url", $url);
    $this->smarty->assign("time", $time);
		//显示视图文件
    $this->smarty->show("jump",1);
    die(); //中止程序向下运行
  }
}