<?php
namespace Home\Controller;
use \Frame\Libs\BaseController;
use \Home\Model\IndexModel;

final class IndexController extends BaseController{

  //---------index----------
  public function index(){
    $modelObj = IndexModel::getInstance();
    $arrs = $modelObj->fetchAll();
    $this->smarty->assign("arrs",$arrs);
    $this->smarty->show("index");

  }
  //---------index---------

  //-------add-----------
  public function add(){
    $this->smarty->show("add");
  }
  //-------add-----------
  public function insert(){
    $data['user_name']  = $_POST['username'];
    $data['title']      = $_POST['title'];
    $data['type']       = $_POST['type'];
    $data['content']    = $_POST['content'];
    $date['addate']     = time();
    
    
    $modelObj = IndexModel::getInstance();
    // if($modelObj->insert()){
    //   $this->jump("")
    // }
    
  }
}