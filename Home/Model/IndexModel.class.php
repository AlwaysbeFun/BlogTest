<?php
namespace Home\Model;
use \Frame\Libs\BaseModel;
final class IndexModel extends BaseModel{

  //-----------------fetchAll------------------------
  public function fetchAll(){
    $sql = "SELECT * FROM  article ORDER BY id DESC";
    return $this->pdo->fetchAll($sql);
  }
  //-----------------fetchAll------------------------

  //-----------------insert--------------------------
  public function insert($data){
    $fields = "";
    $values = "";
    foreach($data as $key => $value){
      $fields .= "$key,";
      $values .= "'$value',";
    }
    $fields = rtrim($fields,",");
    $values = rtrim($values,",");
    $sql    = "INSERT INTO artical($fields) VALUES($values)";
    return $this->pdo->exec($sql);
  }
  //-----------------insert--------------------------

}