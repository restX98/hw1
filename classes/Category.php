<?php

require_once 'DatabaseMgr.php';
require_once 'Address.php';

class Category {
    public $id;
    public $name;
    public $url;

    public function __construct($id, $name) {
      $this->id = $id;
      $this->name = strtoupper($name);
      $formattedName = str_replace(" ", "_", strtolower($name));
      $this->url = "/$formattedName";
    }
}
?>
