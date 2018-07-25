<?php
namespace Home\Controller;

use \Frame\Libs\BaseController;

final class ImageController extends BaseController
{
  private $image_title;
  private $files;
  
  //引入上传图片视图
  public function upload(){
    $this->smarty->show("upload");
  }
  //公共的上传图片的方法
  public function uploadFile()
  {
    $this->image_title = $_POST['image_title'];
    //(1)判断上传文件有没有错误
    if ($_FILES['uploadFile']['error'] != 0) {
      echo "<h2>上传文件有错误！</h2>";
      header("refresh:3;url=?c=Image&a=index");
      die();
    }
	//(2)判断文件的大小是否超出2MB
    if ($_FILES['uploadFile']['size'] > 2 * 1024 * 1024) {
      echo "<h2>上传文件不能超过2MB！</h2>";
      header("refresh:3;url=?c=Image&a=index");
      die();
    }	
	//(3)判断上传文件是不是图片
    $arr1 = ['jpg', 'png', 'gif'];
    $ext = pathinfo($_FILES['uploadFile']['name'], PATHINFO_EXTENSION);
    if (!in_array($ext, $arr1)) {
      echo "<h2>上传文件必须是图片！</h2>";
      header("refresh:3;url=?c=Image&a=index");
      die();
    }
	//(4)判断上传文件的MIME类型是不是图片
    $arr2 = ['image/jpeg', 'image/png', 'image/gif'];
    $mime = $_FILES['uploadFile']['type'];
    if (!in_array($mime, $arr2)) {
      echo "<h2>上传文件的类型不正确！</h2>";
      header("refresh:3;url=?c=Image&a=index");
      die();
    }

	//(4)移动文件：将临时文件移动到网站目录下
    $tmp_name = $_FILES['uploadFile']['tmp_name'];
    $dst_name = "./imagetemp/" . uniqid('s_', true) . ".$ext";
    $this->files = $dst_name;
    move_uploaded_file($tmp_name, $dst_name);
    // $this->smarty->jump("文件上传成功","?c=Image&a=index");
    echo "<h2>上传文件成功！</h2>";
    header("refresh:3;url=?c=Image&a=index");
    die();
  }

  //引入视图文件
  public function index()
  {
    $files = $this->files;
    $imagetitle = $this->image_title;
    $this->smarty->assign(array(
      "imagetitle" => $imagetitle,
      "files" => $files
    ));
    $this->smarty->show("index");
  }
  
  
}

