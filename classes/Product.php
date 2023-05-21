<?php

require_once 'DatabaseMgr.php';
require_once 'Address.php';

class Product {
    private $id;
    private $cod;
    private $name;
    private $price;
    private $category;

    public function __construct($id, $cod, $name, $price, $category) {
      $this->id = $id;
      $this->cod = $cod;
      $this->name = $name;
      $this->price = $price;
      $this->category = $category;
    }
}
?>
