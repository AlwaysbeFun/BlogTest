<?php
namespace Home\Controller;

use \Home\Model\IndexModel;

final class IndexController{
  public function index(){
    $modelObj = new IndexModel();
    $arrs = $modelObj->fetchAll();
    include(VIEW_PATH."index.html");
  }
}