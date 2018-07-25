<?php
namespace Home\Model;
use \Frame\Libs\BaseModel;
final class IndexModel extends BaseModel{

  protected $table = "article";
  //-----------------fetchAll------------------------
  public function fetchAll(){
    $sql = "SELECT article.*,user.username FROM article INNER JOIN user ON article.user_id=user.id ORDER BY article.id DESC";
    return $this->pdo->fetchAll($sql);
  }
  //-----------------fetchAll------------------------

  //-----------------insert--------------------------
  // public function insert($data){
  //   $fields = "";
  //   $values = "";
  //   foreach($data as $key => $value){
  //     $fields .= "$key,";
  //     $values .= "'$value',";
  //   }
  //   $fields = rtrim($fields,",");
  //   $values = rtrim($values,",");
  //   $sql    = "INSERT INTO article($fields) VALUES($values)";
  //   return $this->pdo->exec($sql);
  // }
  //-----------------insert--------------------------

}