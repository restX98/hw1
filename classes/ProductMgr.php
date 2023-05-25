<?php
require_once 'DatabaseMgr.php';
require_once 'Product.php';
require_once 'Category.php';

class ProductMgr {
    private $databaseManager;

    public function __construct() {
        $this->databaseManager = new DatabaseMgr();
    }

    public function getProduct($cod) {
        $productRow = $this->databaseManager->getProduct($cod);
        return new Product(
            $productRow->id,
            $productRow->cod,
            $productRow->NAME,
            $productRow->price,
            $productRow->category
        );
    }

    public function getCategories() {
        $categoriesRow = $this->databaseManager->getCategories();

        $categories = array();
        foreach ($categoriesRow as $row) {
            $categories[] = new Category(
                $row->id,
                $row->name
            );
        }

        return $categories;
    }
}
?>