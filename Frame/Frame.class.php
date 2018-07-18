<?php
//声明命名空间
namespace Frame;
//定义最终的初始化类
final class Frame{
  //公共的静态的初始化框架方法
  public static function run(){
    self::initConfig(); //初始化配置信息
    self::initRoute();  //初始化路由信息
    self::initConst();  //初始化常量信息
    self::initAutoLoad();//初始化自动加载
    self::initDispatch(); //初始化请求分发
  }

  //私有的静态的初始化配置信息
  private static function initConfig(){
    $GLOBALS['config'] = require_once(APP_PATH."Conf".DS."Config.php");
  }

  //私有的静态的初始化路由信息
  private static function initRoute(){
    $p = $GLOBALS['config']['default_platform'];
    $c = isset($_GET['c']) ? $_GET['c'] : $GLOBALS['config']['default_controller'];
    $a = isset($_GET['a']) ? $_GET['a'] : $GLOBALS['config']['default_action'];
    define("PLAT",$p);
    define("CONTROLLER",$c);
    define("ACTION",$a);
  }

  //私有的静态的初始化常量
  private static function initConst(){
    define("VIEW_PATH",APP_PATH."View".DS.CONTROLLER.DS);
  }

  //私有的静态的类的自动加载
  private static function initAutoLoad(){
    spl_autoload_register(function($className){
      $filename = ROOT_PATH.str_replace('\\',DS,$className).'.class.php';
      
      if(file_exists($filename)){
        require_once($filename);
        // echo $filename. "<br>";
      }
    });
  }
  //私有的静态的请求分发
  private static function initDispatch(){
    $controllerClassName = "\\".PLAT."\\"."Controller"."\\".CONTROLLER."Controller";
    $controllerObj = new $controllerClassName();
    $actionName = ACTION;
    $controllerObj -> $actionName();
  }
}