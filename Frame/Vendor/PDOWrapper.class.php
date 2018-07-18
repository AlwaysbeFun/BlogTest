<?php
namespace Frame\Vendor;
use \PDO;
use \EXPECTION;
final class PDOWrapper{
  private $db_type;
  private $db_port;
  private $db_host;
  private $db_user;
  private $db_pass;
  private $db_name;
  private $charset;
  private $pdo = NULL;
  public function __construct()
  {
    $this->db_type = $GLOBALS['config']['db_type'];
    $this->db_port = $GLOBALS['config']['db_port'];
    $this->db_host = $GLOBALS['config']['db_host'];
    $this->db_user = $GLOBALS['config']['db_user'];
    $this->db_pass = $GLOBALS['config']['db_pass'];
    $this->db_name = $GLOBALS['config']['db_name']; 
    $this->charset = $GLOBALS['config']['charset'];   
    $this->connectDb();
    $this->setErrMode();
  }
  private function connectDb(){
    try{
      $dsn = "{$this->db_type}:host={$this->db_host};port={$this->db_port};dbname={$this->db_name};charset={$this->charset}";
      $this->pdo = new PDO($dsn,$this->db_user,$this->db_pass);
    }catch(Exception $e){
      $str = "<h1>创建PDO对象失败</h1>";
      $str .= "错误编号：" . $e -> getCode();
      $str .= "错误行号：" . $e -> getLine();
      $str .= "错误文件：" . $e -> getFile();
      $str .= "错误信息：" . $e -> getMessage();
      echo $str; 
    }
  }
  
  //设置报错模式
  private function setErrMode(){
    $this->pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
  }
  //设置错误信息
  private function showErr($e){
    $str = "<h1>SQL语句发生错误</h1>";
    $str .= "错误编号：" . $e -> getCode();
    $str .= "错误行号：" . $e -> getLine();
    $str .= "错误文件：" . $e -> getFile();
    $str .= "错误信息：" . $e -> getMessage();
    echo $str; 
  }
  //获取一行
  public function fetchOne($sql){
    try{
      $PDOStatement = $this->pdo->query($sql);
      return $PDOStatement->fetchOne(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      $this->showErr($e);
    }
  }
  //获取多行数据
  public function fetchAll($sql){
    try{
      $PDOStatement = $this->pdo->query($sql);
      return $PDOStatement->fetchAll(PDO::FETCH_ASSOC);
    }catch(Exception $e){
      $this->showErr($e);
    }
  }
  //获取所有数量
  public function rowCount($sql){
    $PDOStatement = $this->pdo->query($sql);
    
  }
}