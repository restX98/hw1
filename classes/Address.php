<?php

require_once 'DatabaseMgr.php';

class Address {
    private $id;
    private $street;
    private $houseNumber;
    private $postalCode;
    private $city;
    private $province;
    private $country;

    public function __construct($id, $street, $houseNumber, $postalCode, $city, $province, $country) {
        $this->id = $id;
        $this->street = $street;
        $this->houseNumber = $houseNumber;
        $this->postalCode = $postalCode;
        $this->city = $city;
        $this->province = $province;
        $this->country = $country;
    }
}
?>
