<?php

require_once 'DatabaseMgr.php';
require_once 'Address.php';

class Category {
    public $id;
    public $name;
    public $cod;
    public $url;

    public function __construct($id, $name, $cod) {
      $this->id = $id;
      $this->name = strtoupper($name);
      $this->cod = $cod;
      $this->url = "/hw1/category/$cod";
    }
}
?>
