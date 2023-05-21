<?php

require_once 'DatabaseMgr.php';
require_once 'Address.php';

class Customer {
    private $id;
    private $firstName;
    private $lastName;
    private $email;
    private $phoneNumber;

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
}
?>
