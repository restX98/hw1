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
        if(is_null($productRow)){
            return null;
        }
        
        $category = new Category(
            $productRow->category,
            $productRow->categoryName,
            $productRow->categoryCod
        );
        return new Product(
            $productRow->id,
            $productRow->cod,
            $productRow->name,
            $productRow->price,
            $category
        );
    }

    public function getCategories() {
        $categoriesRow = $this->databaseManager->getCategories();

        $categories = array();
        foreach ($categoriesRow as $row) {
            $categories[] = new Category(
                $row->id,
                $row->name,
                $row->cod
            );
        }

        return $categories;
    }

    public function getProducts($category = null) {
        $productsRow = $this->databaseManager->getProductsByCategory($category);

        $products = array();
        foreach ($productsRow as $row) {
            $category = new Category(
                $row->category,
                $row->categoryName,
                $row->categoryCod
            );
            $products[] = new Product(
                $row->id,
                $row->cod,
                $row->name,
                $row->price,
                $category
            );
        }

        return $products;
    }
}
?>