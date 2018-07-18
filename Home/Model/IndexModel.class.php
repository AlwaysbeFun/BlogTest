<?php
namespace Home\Model;
use \Frame\Libs\BaseModel;
final class IndexModel extends BaseModel{


  
  public function fetchAll(){
    $sql = "SELECT * FROM  article ORDER BY id DESC";
    return $this->pdo->fetchAll($sql);
  }
}