<?php
require_once 'ItemsContainer.php';

class Basket extends ItemsContainer {
  public function __construct($id, $creationDate, $items) {
    parent::__construct($id, $creationDate, $items);
  }
}
