<?php
//声明命名空间
namespace Admin\Controller;

use \Frame\Libs\BaseController;
use \Admin\Model\CategoryModel;
use \Admin\Model\ArticleModel;

//定义文章控制器类，并继承基础控制器类
final class ArticleController extends BaseController
{
	
	//显示文章列表
	public function index()
	{
		//用户权限验证
		$this->denyAccess();
		//获取文章无限级分类数据
		$categorys = CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll()
		);

		//构建搜索条件
		$where = "2>1";
		if (!empty($_REQUEST['category_id'])) $where .= " AND category_id=" . $_REQUEST['category_id'];
		if (!empty($_REQUEST['keyword'])) $where .= " AND title LIKE '%" . $_REQUEST['keyword'] . "%'";

 	//构建分页参数
		$pagesize = 15;
		$page = isset($_GET['page']) ? $_GET['page'] : 1;
		$startrow = ($page - 1) * $pagesize; //开始行号
		$records = ArticleModel::getInstance()->rowCount($where);
		$params = array('c' => CONTROLLER, 'a' => ACTION);
		if (!empty($_REQUEST['category_id'])) $params['category_id'] = $_REQUEST['category_id'];
		if (!empty($_REQUEST['keyword'])) $params['keyword'] = $_REQUEST['keyword'];		

		//创建分页类的对象
		$pageObj = new \Frame\Vendor\pager($records, $pagesize, $page, $params);
		$pageStr = $pageObj->showPage();

		//获取连表查询的分页的文章数据
		$articles = ArticleModel::getInstance()->fetchAllWithJoin($where, $startrow, $pagesize);
		//获取数据表中文章记录数
		$articleCount = ArticleModel::getInstance()->rowCount("2>1");
		//获取数据表中所有数据
		$arrs = ArticleModel::getInstance()->fetchAll();
		//向视图赋值，并显示视图
		$this->smarty->assign(array(
			'categorys' => $categorys,
			'articles' => $articles,
			'pageStr' => $pageStr,
			'articleCount' => $articleCount,
			'arrs' => $arrs
		));
		$this->smarty->show("index");
	}

	//显示添加的表单
	public function add()
	{
		//用户权限验证
		$this->denyAccess();
		//获取文章无限级分类数据
		$categorys = CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll()
		);
		//向视图赋值，并显示视图
		$this->smarty->assign("categorys", $categorys);
		$this->smarty->show("add");
	}

	//插入数据
	public function insert()
	{
		//用户权限验证
		$this->denyAccess();
		//获取表单提交值
		$data['category_id'] = $_POST['category_id'];
		$data['user_id'] = $_SESSION['uid'];
		$data['title'] = $_POST['title'];
		$data['content'] = $_POST['content'];
		$data['top'] = isset($_POST['top']) ? 1 : 0;
		$data['addate'] = time();
		//判断数据是否插入成功
		if (ArticleModel::getInstance()->insert($data)) {
			$this->jump("文章添加成功！", "?c=Article&a=index");
		} else {
			$this->jump("文章添加失败！", "?c=Article&a=add");
		}
	}
	//获取文章记录数
	public function arricleCount()
	{
		//用户权限验证
		$this->denyAccess();
		$articleCount = ArticleModel::getInstance()->rowCount();
		$this->smarty->assign("articleCount", $articleCount);
	}
	//公共的删除文章方法
	public function delete()
	{
		//用户权限验证
		$this->denyAccess();
		$id = $_GET['id'];
		//判断用户是否删除成功
		if (ArticleModel::getInstance()->delete($id)) {
			$this->jump("文章删除成功！", "?c=Article&a=index");
		} else {
			$this->jump("文章删除失败！", "?c=Article&a=index");
		}
	}

	//公共的添加的方法
	public function edit()
	{
		$categorys = CategoryModel::getInstance()->categoryList(
			CategoryModel::getInstance()->fetchAll()
		);
		$id = $_GET['id'];
		$arr = ArticleModel::getInstance()->fetchOne("id={$id}");
		$this->smarty->assign(array(
			"arr" => $arr,
			"categorys" => $categorys
		));
		$this->smarty->show("edit");
	}

	//公共的更新的方法
	public function update()
	{
		$id = $_POST['update'];
		$data['title'] = $_POST['title'];
		$data['category_id'] = $_POST['category_id'];
		$data['content'] = $_POST['content'];
		if (ArticleModel::getInstance()->update($data, $id)) {
			$this->jump("文章更新成功！", "?c=Article&a=index");
		} else {
			$this->jump("文章更新失败！", "?c=Article&a=edit");
		}
	}
}
