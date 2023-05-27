<?php

require_once 'DatabaseMgr.php';
require_once 'Address.php';
require_once 'Product.php';

class Customer {
    private $id;
    public $firstName;
    public $lastName;
    public $email;
    public $phoneNumber;

    public function __construct($id, $firstName, $lastName, $email, $phoneNumber) {
      $this->id = $id;
      $this->firstName = $firstName;
      $this->lastName = $lastName;
      $this->email = $email;
      $this->phoneNumber = $phoneNumber;
    }

    public function addAddress($street, $houseNumber, $postalCode, $city, $province, $country) {
        $DatabaseMgr = new DatabaseMgr();
        $addressId = $DatabaseMgr->addAddressToCustomer($street, $houseNumber, $postalCode, $city, $province, $country, $this->id);
        return new Address(
            $addressId,
            $street,
            $houseNumber,
            $postalCode,
            $city,
            $province,
            $country
        );
    }

    public function getAddresses() {
        $DatabaseMgr = new DatabaseMgr();
        $addressRows = $DatabaseMgr->getCustomerAddresses($this->id);
        $addresses = array();
        foreach ($addressRows as $row) {
            $addresses[] = new Address(
                $row->ID,
                $row->street,
                $row->houseNumber,
                $row->postalCode,
                $row->city,
                $row->province,
                $row->country
            );
        }
        return $addresses;
    }

    public function addProductToWishlist($product) {
        $DatabaseMgr = new DatabaseMgr();
        $DatabaseMgr->addProductToWishlist($this->id, $product->id);
    }

    public function getWishlistProducts() {
        $DatabaseMgr = new DatabaseMgr();
        $productRows = $DatabaseMgr->getWishlistProducts($this->id);
        $products = array();
        foreach ($productRows as $row) {
            $products[] = new Product(
                $row->id,
                $row->cod,
                $row->NAME,
                $row->price,
                $row->categoryName
            );
        }
        return $products;
    }
}
?>
