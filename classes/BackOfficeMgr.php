<?php
require_once 'DatabaseMgr.php';

class BackOfficeMgr {
    private $databaseManager;

    public function __construct() {
        $this->databaseManager = new DatabaseMgr();
    }

    public function createCategory($categoryName) {
        $this->databaseManager->createCategory($categoryName);
    }

    public function updateCategory($id, $categoryName) {
        $this->databaseManager->updateCategory($id, $categoryName);
    }

    public function removeCategory($id) {
        $this->databaseManager->removeCategory($id);
    }

    public function createProduct($cod, $name, $price, $categoryId) {
        $this->databaseManager->createProduct($cod, $name, $price, $categoryId);
    }

    public function updateProduct($id, $cod, $name, $price, $categoryId) {
        $this->databaseManager->updateProduct($id, $cod, $name, $price, $categoryId);
    }

    public function removeProduct($id) {
        $this->databaseManager->removeProduct($id);
    }
}
?>