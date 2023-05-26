<?php

require_once 'DatabaseMgr.php';
require_once 'Address.php';

class Product {
    public $id;
    public $cod;
    public $name;
    public $price;
    public $category;
    public $url;

    public function __construct($id, $cod, $name, $price, $category) {
      $this->id = $id;
      $this->cod = $cod;
      $this->name = $name;
      $this->price = $price;
      $this->category = $category;
      $this->url = "/hw1/product/$cod";
    }
}
?>
