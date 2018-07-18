<?php
namespace Frame\Libs;

use \Frame\Vendor\PDOWrapper;

abstract class BaseModel{
  protected $pdo = NULL;
  public function __construct()
  {
    $this->pdo = new PDOWrapper();
  }
}