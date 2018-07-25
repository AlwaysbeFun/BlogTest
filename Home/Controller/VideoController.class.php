<?php
namespace Home\Controller;

use \Frame\Libs\BaseController;

final class VideoController extends BaseController{
 //公共的显示视图方法
 public function index(){
   $this->smarty->show("index");
 }
}