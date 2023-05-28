<?php
require_once 'BasketMgr.php';
require_once 'ItemsContainer.php';

class Basket extends ItemsContainer {
    public function __construct($id, $creationDate, $items) {
        parent::__construct($id, $creationDate, $items);
    }

    public function addProduct($productCod) {
        $databaseManager = new DatabaseMgr();
        
        $result = $databaseManager->addProductToCart($this->id, $productCod);
        if (isset($result['error']) && $result['error'] === true) {
            throw new Exception("Database error.");
        }

        BasketMgr::updateBasket($this);
        
        return $result;
    }

    public function removeProduct($productCod) {
        $databaseManager = new DatabaseMgr();
        
        $result = $databaseManager->removeProductFromCart($this->id, $productCod);
        if (isset($result['error']) && $result['error'] === true) {
            throw new Exception("Database error.");
        }

        BasketMgr::updateBasket($this);
        
        return $result;
    }
}
