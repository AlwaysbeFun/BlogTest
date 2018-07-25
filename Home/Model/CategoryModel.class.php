<?php
//声明命名空间
namespace Home\Model;
use \Frame\Libs\BaseModel;

//定义最终的文章分类模型类，并继承基础模型类
final class CategoryModel extends BaseModel
{
	//受保护的数据表名称
	protected $table = "category";

	//获取无限级分类数据
	public function categoryList($arrs,$level=0,$pid=0)
	{
		//参数说明：
		//$arrs代表原始的分类数据
		//$level代表菜单的层级，从0开始计数，用来计算缩进的空格数
		//$pid代表传递过来的上层菜单的ID
		//静态变量：静态的保存结果的新数组
		//静态变量：函数调用完毕，静态变量数据不会消失
		//静态变量：只在第1次调用时初始化一次，以后不再初始化
		static $categorys = array();
		//循环原始的分类数据
		foreach($arrs as $arr)
		{
			//如果当前pid和传递过来的ID相等，则添加到新数组中
			if($arr['pid']==$pid)
			{
				$arr['level'] = $level; //添加菜单等级元素
				$categorys[] = $arr;
				//递归调用
				$this->categoryList($arrs,$level+1,$arr['id']);
			}
		}
		//返回无限级分类数据
		return $categorys;
	}
}