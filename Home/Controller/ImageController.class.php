<?php
namespace Home\Controller;
use \Frame\Libs\BaseController;
final class ImageController extends BaseController{
  public function index(){
    $this->smarty->show("index");
  }
  public function upload(){
    $this->smarty->show("upload");
  }
}