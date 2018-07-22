<?php
//声明命名空间
namespace Frame\Vendor;
use \PDO;
use \Exception;

//定义最终的PDOWrapper类
final class PDOWrapper
{
	//私有的数据库配置属性
  private $db_type;
  private $db_host;
  private $db_port;
  private $db_user;
  private $db_pass;
  private $db_name;
  private $charset;
  private $pdo = null;

	//公共的构造方法
  public function __construct()
  {
    $this->db_type = $GLOBALS['config']['db_type'];
    $this->db_host = $GLOBALS['config']['db_host'];
    $this->db_port = $GLOBALS['config']['db_port'];
    $this->db_user = $GLOBALS['config']['db_user'];
    $this->db_pass = $GLOBALS['config']['db_pass'];
    $this->db_name = $GLOBALS['config']['db_name'];
    $this->charset = $GLOBALS['config']['charset'];
    $this->connectDb(); //创建PDO对象
    $this->setErrMode(); //设置PDO的报错模式
  }

	//私有的创建PDO对象的方法
  private function connectDb()
  {
    try {
			//构建DSN字符串：$dsn = "mysql:host=主机名;port=端口号;dbname=数据库名;charset=字符集"
      $dsn = "{$this->db_type}:host={$this->db_host};port={$this->db_port};";
      $dsn .= "dbname={$this->db_name};charset={$this->charset}";
			//创建PDO对象
      $this->pdo = new PDO($dsn, $this->db_user, $this->db_pass);
    } catch (Exception $e) {
      $str = "<h2>创建PDO对象失败！</h2>";
      $str .= "错误编号：" . $e->getCode();
      $str .= "<br>错误行号：" . $e->getLine();
      $str .= "<br>错误文件：" . $e->getFile();
      $str .= "<br>错误信息：" . $e->getMessage();
      echo $str;
    }
  }

	//私有的设置PDO的报错模式为异常模式
  private function setErrMode()
  {
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  }

	//公共的执行SQL语句的方法：insert、update、delete、set、drop等
	//执行成功返回受影响行数，执行失败会返回false
  public function exec($sql)
  {
    try {
      return $this->pdo->exec($sql);
    } catch (Exception $e) {
      $this->showError($e);
    }
  }

	//私有的错误处理方法
  private function showError($e)
  {
    $str = "<h2>SQL语句有问题！</h2>";
    $str .= "错误编号：" . $e->getCode();
    $str .= "<br>错误行号：" . $e->getLine();
    $str .= "<br>错误文件：" . $e->getFile();
    $str .= "<br>错误信息：" . $e->getMessage();
    echo $str;
  }

	//获取一行数据
  public function fetchOne($sql)
  {
    try {
			//执行查询的SQL语句，并返回结果集对象(PDOStatement)
      $PDOStatement = $this->pdo->query($sql);
			//从结果集对象中获取一行数据，并返回
      return $PDOStatement->fetch(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      $this->showError($e);
    }
  }

	//获取多行数据
  public function fetchAll($sql)
  {
    try {
			//执行查询的SQL语句，并返回结果集对象(PDOStatement)
      $PDOStatement = $this->pdo->query($sql);
			//从结果集对象中获取多行数据，并返回
      return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      $this->showError($e);
    }
  }

	//获取记录数
  public function rowCount($sql)
  {
    try {
			//执行查询的SQL语句，并返回结果集对象(PDOStatement)
      $PDOStatement = $this->pdo->query($sql);
			//从结果集对象中获取记录数，并返回
      return $PDOStatement->rowCount();
    } catch (Exception $e) {
      $this->showError($e);
    }
  }
}