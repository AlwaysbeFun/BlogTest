<?php
namespace Frame\Libs;

use \Frame\Vendor\PDOWrapper;

abstract class BaseModel
{
  protected $pdo = null;
  public function __construct()
  {
    $this->pdo = new PDOWrapper();
  }

  //私有的静态的保存不同模型类数组
  private static $arrmodelObj = array();
  //公共的静态的构建单例模型类方法
  public static function getInstance()
  {
    $modelClassName = get_called_class();
    if (!isset(self::$arrmodelObj[$modelClassName])) {
      self::$arrmodelObj[$modelClassName] = new $modelClassName;
    }
    return self::$arrmodelObj[$modelClassName];
  }

  //获取一行数据
  public function fetchOne($where = "2>1")
  {
		//构建查询的SQL语句
    $sql = "SELECT * FROM {$this->table} WHERE {$where} LIMIT 1";
		//执行SQL语句，并返回结果(一维数组)
    return $this->pdo->fetchOne($sql);
  }

	//获取多行数据
  public function fetchAll()
  {
		//构建查询的SQL语句
    $sql = "SELECT * FROM {$this->table} ORDER BY id ASC";
		//执行SQL语句，并返回结果(二维数组)
    return $this->pdo->fetchAll($sql);
  }

	//删除数据
  public function delete($id)
  {
		//构建删除的SQL语句
    $sql = "DELETE FROM {$this->table} WHERE id={$id}";
		//执行SQL语句，并返回结果(布尔值)
    return $this->pdo->exec($sql);
  }

	//获取记录数
  public function rowCount($where)
  {
		//构建查询的SQL语句
    $sql = "SELECT * FROM {$this->table} WHERE {$where}";
		//执行SQL语句，并返回结果(整数)
    return $this->pdo->rowCount($sql);
  }

	//插入记录
  public function insert($data)
  {
		//构建"字段列表"和"值列表"的字符串
    $fields = "";
    $values = "";
    foreach ($data as $key => $value) {
      $fields .= "$key,";
      $values .= "'$value',";
    }
		//去除结末的逗号
    $fields = rtrim($fields, ',');
    $values = rtrim($values, ',');

		//获取插入的SQL语句
    $sql = "INSERT INTO {$this->table}($fields) VALUES($values)";
		//执行SQL语句，并返回结果(布尔值)
    return $this->pdo->exec($sql);
  }

	//更新记录的方法
  public function update($data, $id)
  {
		//构建"name=value"的字符串
    $str = "";
    foreach ($data as $key => $value) {
      $str .= "$key='$value',";
    }
		//去除字符串结尾的逗号
    $str = rtrim($str, ',');

		//构建更新的SQL语句
    $sql = "UPDATE {$this->table} SET {$str} WHERE id={$id}";
		//执行SQL语句，并返回结果(布尔值)
    return $this->pdo->exec($sql);
  }
}