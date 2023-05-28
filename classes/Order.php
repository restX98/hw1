<?php
require_once 'BasketMgr.php';
require_once 'ItemsContainer.php';

class Order extends ItemsContainer {
    public $status;
    public $address;

    public function __construct($id, $status, $items, $address) {
        parent::__construct($id, $items);
        $this->$status = $status;
        $this->address = $address;
    }
}
