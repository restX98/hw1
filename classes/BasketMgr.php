<?php
require_once 'DatabaseMgr.php';
require_once 'LineItem.php';
require_once 'Category.php';
require_once 'Basket.php';
require_once 'Session.php';
require_once 'Exceptions.php';

class BasketMgr {
    public static function getCurrentBasket() {
        $databaseManager = new DatabaseMgr();
        $id = Session::get("sessionId");
        if(isset($id)) {
            $basket = $databaseManager->createCartItemsContainer($id);

            if (isset($basket['error']) && $basket['error'] === true) {
                if (isset($basket['customerNotFound']) &&  $basket['customerNotFound'] === true) {
                    throw new CustomerNotFoundException("Email non valida.");
                } else {
                    throw new Exception("Database error.");
                }
            }


            $itemsRow = $databaseManager->getItemsContainer($basket['containerId']);

            $lineItem = self::getLineItems($itemsRow);

            return new Basket(
                $basket['containerId'],
                $lineItem
            );
        } else {
            return throw new CustomerNotAuthenticatedException();
        }
    }

    public static function updateBasket($basket) {
        $databaseManager = new DatabaseMgr();
        $itemsRow = $databaseManager->getItemsContainer($basket->id);

        $lineItems = self::getLineItems($itemsRow);

        $basket->setItems($lineItems);
        $basket->calculateTotalQuantity();
        $basket->calculateTotalPrice();
    }

    private static function getLineItems($itemsRow) {
        $lineItem = array();
        foreach ($itemsRow as $row) {
            $category = new Category(
                $row['categoryId'],
                $row['categoryName'],
                $row['categoryCode']
            );

            $lineItem[] = new LineItem(
                $row['lineItemId'],
                $row['productCode'],
                $row['productName'],
                $row['productPrice'],
                $category,
                $row['quantity']
            );
        }
        return $lineItem;
    }
}

?>