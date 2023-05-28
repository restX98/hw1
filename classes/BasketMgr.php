<?php
require_once 'DatabaseMgr.php';
require_once 'LineItem.php';
require_once 'Category.php';
require_once 'Basket.php';
require_once 'Session.php';
require_once 'Exceptions.php';

class BasketMgr {
    public static function getCurrentOrNewBasket() {
        $databaseManager = new DatabaseMgr();
        $id = Session::get("sessionId");
        if(isset($id)) {
            $basket = $databaseManager->createCartItemsContainer($id);

            if (isset($customerRow['error']) && $customerRow['error'] === true) {
                if ($customerRow['customerNotFound'] === true) {
                    throw new CustomerNotFoundException("Email non valida.");
                } else {
                    throw new Exception("Database error.");
                }
            }

            $itemsRow = $databaseManager->getItemsContainer($basket['containerId']);

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

            return new Basket(
                $basket['containerId'],
                $basket['creationDate'],
                $lineItem
            );
        } else {
            return throw new CustomerNotAuthenticatedException();
        }
    }
}

?>