<?php
namespace Frame\Vendor;
require(ROOT_PATH."Frame".DS."Vendor".DS."Smarty".DS."libs".DS."Smarty.class.php");
//定义最终的Smarty类，并继承原始的Smarty
final class Smarty extends \Smarty{
  //定义新的视图方法
  //参数$template为视图文件名称，参数$template，参数$template_public为是否为公共属兔目录
  public function show($template,$template_public = 0){
    //判断是否为公共视图目录
    if($template_public){
      //如果是公共视图目录，则添加Public目录前缀
      $template = "Public".DS.$template.".html";
    }
    else{
      //如果不是则直接调用视图文件
      $template = CONTROLLER.DS.$template.".html";
    }
    $this->display($template);
  }
}