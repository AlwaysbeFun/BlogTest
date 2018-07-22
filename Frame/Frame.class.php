<?php
//声明命名空间
namespace Frame;

//定义最终的框架初始(核心)类
final class Frame
{
	//公共的静态的框架初始化方法
	public static function run()
	{
		self::initConfig();		//初始化配置文件
		self::initRoute();		//初始化路由参数
		self::initConst();		//初始化目录常量
		self::initAutoLoad();	//初始化类的自动加载
		self::initDispatch();	//初始化请求分发
	}

	//私有的静态的初始化配置文件
	private static function initConfig()
	{
		//开启SESSION会话
		session_start();
		//读取配置文件数据
		$GLOBALS['config'] = require_once(APP_PATH."Conf".DS."Config.php");
	}

	//私有的静态的初始化路由参数
	private static function initRoute()
	{
		$p = $GLOBALS['config']['default_platform'];
		$c = isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['default_controller'];
		$a = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['default_action'];
		define("PLAT",$p);
		define("CONTROLLER",$c);
		define("ACTION",$a);
	}

	//私有的静态的目录常量设置
	private static function initConst()
	{
		define("VIEW_PATH",APP_PATH."View".DS); //视图文件目录
	}

	//私有的静态的类的自动加载
	private static function initAutoLoad()
	{
		spl_autoload_register(function($className){
			//传递的空间+类名称：\Home\Controller\StudentController
			//真实的类文件路径：e:/itcast/lesson/blog1/Home/Controller/StudentController.class.php
			//构建类文件路径：将传递的空间+类名，转换成真实的类文件路径
			$filename = ROOT_PATH.str_replace('\\',DS,$className).".class.php";
			//如果类文件存在，则包含
			if(file_exists($filename)) require_once($filename); 
		});
	}

	//私有的静态的请求分发的方法：创建哪个控制器类的对象？调用控制器对象的哪个方法？
	private static function initDispatch()
	{
		//构建控制器类名称：例如：\Admin\Controller\StudentController
		$controllerClassName = "\\".PLAT."\\Controller\\".CONTROLLER."Controller";
		//创建控制器类的对象
		$controllerObj = new $controllerClassName();
		//调用控制器对象的方法
		$actionName = ACTION;
		$controllerObj->$actionName();
	}
}