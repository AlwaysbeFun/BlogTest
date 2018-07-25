<?php
namespace Home\Controller;

use \Frame\Libs\BaseController;
use \Home\Model\IndexModel;
use \Home\Model\CategoryModel;

final class IndexController extends BaseController
{

  public function insert()
  {
    $data['title'] = $_POST['title'];
    $data['category_id'] = $_POST['category_id'];
    $data['content'] = $_POST['content'];
    $data['addate'] = time();
    if (IndexModel::getInstance()->insert($data)) {
      $this->jump("文章添加成功！", "?c=Index&a=index");
    } else {
      $this->jump("文章添加失败！", "?c=Index&a=add");
    }
  }

  //显示添加的表单
  public function add()
  {
		// //用户权限验证
    // $this->denyAccess();
		//获取无限级分类的数据
    $categorys = CategoryModel::getInstance()->categoryList(
      CategoryModel::getInstance()->fetchAll()
    );
		//向视图赋值，并显示视图
    $this->smarty->assign("categorys", $categorys);
    $this->smarty->show("add");
  }
//---------index----------
  public function index()
  {
    $arrs = IndexModel::getInstance()->fetchAll();
    $this->smarty->assign("arrs", $arrs);
    $this->smarty->show("index");
  }
//---------index---------
}