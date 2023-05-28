<?php
require_once 'Product.php';

class LineItem extends Product {
  
  public $quantity;

  public function __construct($id, $cod, $name, $price, $category, $quantity) {
    parent::__construct($id, $cod, $name, $price, $category);
    $this->quantity = $quantity;
  }
}
