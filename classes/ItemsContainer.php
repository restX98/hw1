<?php

class ItemsContainer {
    public $id;
    public $creationDate;
    public $items;
    public $totalPrice;
    public $totalQuantity;
    
    public function __construct($id, $creationDate, $items) {
        $this->id = $id;
        $this->creationDate = $creationDate;
        $this->items = $items;
        $this->calculateTotalPrice();
        $this->calculateTotalQuantity();
    }

    public function setItems($items) {
        $this->items = $items;
    }

    public function calculateTotalPrice() {
        $totalPrice = 0;
        foreach ($this->items as $item) {
            $totalPrice += $item->price * $item->quantity;
        }
        $this->totalPrice = $totalPrice;
    }

    public function calculateTotalQuantity() {
        $totalQuantity = 0;
        foreach ($this->items as $item) {
            $totalQuantity += $item->quantity;
        }
        $this->totalQuantity = $totalQuantity;
    }
}
