<?php
//声明命名空间
namespace Admin\Controller;
use \Frame\Libs\BaseController;
use \Admin\Model\CategoryModel;

//定义最终的文章分类控制器类，并继承基础控制器类
final class CategoryController extends BaseController
{
	//首页显示方法
	public function index()
	{
		//用户权限验证
    $this->denyAccess();
		//获取分类的原始数据
		$categorys = CategoryModel::getInstance()->fetchAll();
		//获取无限级分类数据
		$categorys = CategoryModel::getInstance()->categoryList($categorys);
		//向视图赋值，并显示视图
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->show("index");
	}

	//显示添加的表单
	public function add()
	{
		//用户权限验证
    $this->denyAccess();
		//获取无限级分类的数据
		$categorys = CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll()
		);
		//向视图赋值，并显示视图
		$this->smarty->assign("categorys",$categorys);
		$this->smarty->show("add");
	}

	//插入数据
	public function insert()
	{
		//用户权限验证
    $this->denyAccess();
		//获取表单提交数据
		$data['classname']		= $_POST['classname'];
		$data['orderby']		= $_POST['orderby'];
		$data['pid']			= $_POST['pid'];
		//判断数据是否写入成功
		if(CategoryModel::getInstance()->insert($data))
		{
			$this->jump("分类添加成功！","?c=Category");
		}else
		{
			$this->jump("分类添加失败！","?c=Category");
		}
	}

	//删除数据
	public function delete()
	{
		//用户权限验证
    $this->denyAccess();
		//获取地址栏传递的ID
		$id = $_GET['id'];

		//判断数据是否删除成功
		if(CategoryModel::getInstance()->delete($id))
		{
			$this->jump("id={$id}记录删除成功！","?c=Category");
		}else
		{
			$this->jump("id={$id}记录删除失败！","?c=Category");
		}
	}
}