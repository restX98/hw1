<?php

require_once 'Basket.php';
require_once 'Order.php';
require_once 'Address.php';

class OrderMgr {

    public static function placeOrder(Basket $basket, Address $address) {
        $databaseManager = new DatabaseMgr();
        $order = $databaseManager->placeOrder($basket->id, $address->id);

        if (isset($order['error']) && $order['error'] === true) {
            throw new Exception("Database error.");
        }

        $itemsRow = $databaseManager->getItemsContainer($order['ID']);

        $lineItem = self::getLineItems($itemsRow);

        return new Order(
            $order['ID'],
            $order['status'],
            $lineItem,
            $address
        );
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