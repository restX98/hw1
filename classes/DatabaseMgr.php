<?php
class DatabaseMgr {
    private $connection;

    public function __construct() {
        $configFilePath = '../config/db.ini';
        $config = parse_ini_file($configFilePath);

        $host = $config['host'];
        $username = $config['username'];
        $password = $config['password'];
        $database = $config['database'];

        $this->connection = mysqli_connect($host, $username, $password, $database);
    }

    public function __destruct() {
        mysqli_close($this->connection);
    }

    public function createCustomer($firstName, $lastName, $email, $psw, $phoneNumber) {
        try{
            $firstName = mysqli_real_escape_string($this->connection, $firstName);
            $lastName = mysqli_real_escape_string($this->connection, $lastName);
            $email = mysqli_real_escape_string($this->connection, $email);
            $psw = mysqli_real_escape_string($this->connection, $psw);
            $psw = password_hash($psw, PASSWORD_BCRYPT);
            $phoneNumber = mysqli_real_escape_string($this->connection, $phoneNumber);

            $query = "CALL CreateCustomer('$firstName', '$lastName', '$email', '$psw', '$phoneNumber')";
            
            $result = mysqli_query($this->connection, $query);
            $customer = mysqli_fetch_assoc($result);
            
            mysqli_free_result($result);

            return $customer;
        } catch(mysqli_sql_exception  $ex) {
            // TODO: Add phoneExists case
            if ($ex->getSQLState() === "45001") {
                return array("error" => true, "customerExists" => true);
            } else {
                return array("error" => true);
            }
        } catch(Exception $ex) {
            return array("error" => true);
        }
    }

    public function getCustomerByLogin($email) {
        try {
            $email = mysqli_real_escape_string($this->connection, $email);
            $query = "CALL GetCustomerByLogin('$email')";

            $result = mysqli_query($this->connection, $query);

            $customer = mysqli_fetch_assoc($result);
            mysqli_free_result($result);

            return $customer;
        } catch(mysqli_sql_exception  $ex) {
            if ($ex->getSQLState() === "45003") {
                return array("error" => true, "mailError" => true);
            } else {
                return array("error" => true);
            }
        } catch(Exception $ex) {
            return array("error" => true);
        }
    }

    public function getCustomerByID($id) {
        try {
            $id = mysqli_real_escape_string($this->connection, $id);

            $query = "CALL GetCustomerByID($id)";

            $result = mysqli_query($this->connection, $query);

            $customer = mysqli_fetch_object($result);
            
            mysqli_free_result($result);

            return $customer;
        } catch(Exception $ex) {
            return null;
        }
    }

    public function addAddressToCustomer($street, $houseNumber, $postalCode, $city, $province, $country, $customerID) {
        $street = mysqli_real_escape_string($this->connection, $street);
        $houseNumber = mysqli_real_escape_string($this->connection, $houseNumber);
        $postalCode = mysqli_real_escape_string($this->connection, $postalCode);
        $city = mysqli_real_escape_string($this->connection, $city);
        $province = mysqli_real_escape_string($this->connection, $province);
        $country = mysqli_real_escape_string($this->connection, $country);
        
        $query = "CALL AddAddressToCustomer('$street', '$houseNumber', '$postalCode', '$city', '$province', '$country', '$customerID')";

        $result = mysqli_query($this->connection, $query);
        $addressId = mysqli_fetch_row($result);

        mysqli_free_result($result);
        
        return $addressId[0];
    }

    public function getCustomerAddresses($customerID) {
        $query = "CALL GetCustomerAddresses('$customerID')";

        $result = mysqli_query($this->connection, $query);
        $addresses = Array();

        while ($row = mysqli_fetch_object($result)) {
            $addresses[] = $row;
        }

        mysqli_free_result($result);

        return $addresses;
    }

    public function getCategories() {
        try {
            $query = "CALL GetCategories()";

            $result = mysqli_query($this->connection, $query);

            $categories = Array();

            while ($row = mysqli_fetch_object($result)) {
                $categories[] = $row;
            }

            mysqli_free_result($result);

            return $categories;
        } catch(Exception $ex) {
            return Array();
        }
    }

    public function createCategory($categoryName) {
        $query = "CALL CreateCategory('$categoryName')";

        $result = mysqli_query($this->connection, $query);
    }

    public function updateCategory($id, $categoryName) {
        $query = "CALL UpdateCategory('$id', '$categoryName')";

        $result = mysqli_query($this->connection, $query);
    }

    public function removeCategory($id) {
        $query = "CALL RemoveCategory('$id')";

        $result = mysqli_query($this->connection, $query);
    }

    public function createProduct($cod, $name, $price, $category) {
        $cod = mysqli_real_escape_string($this->connection, $cod);
        $name = mysqli_real_escape_string($this->connection, $name);
        $price = mysqli_real_escape_string($this->connection, $price);
        $category = mysqli_real_escape_string($this->connection, $category);

        $query = "CALL CreateProduct('$cod', '$name', '$price', '$category')";

        $result = mysqli_query($this->connection, $query);
    }

    public function updateProduct($id, $cod, $name, $price, $category) {
        $cod = mysqli_real_escape_string($this->connection, $cod);
        $name = mysqli_real_escape_string($this->connection, $name);
        $price = mysqli_real_escape_string($this->connection, $price);
        $category = mysqli_real_escape_string($this->connection, $category);

        $query = "CALL UpdateProduct('$id', '$cod', '$name', '$price', '$category')";

        $result = mysqli_query($this->connection, $query);
    }

    public function removeProduct($id) {
        $id = mysqli_real_escape_string($this->connection, $id);
        $query = "CALL RemoveProduct('$id')";

        $result = mysqli_query($this->connection, $query);
    }

    public function getProductsByCategory($category) {
        try{
            $category = mysqli_real_escape_string($this->connection, $category);
            $query = "CALL GetProductsByCategory('$category')";

            $result = mysqli_query($this->connection, $query);

            $product = mysqli_fetch_object($result);

            $products = Array();

            while ($row = mysqli_fetch_object($result)) {
                $products[] = $row;
            }

            mysqli_free_result($result);

            return $products;
        } catch(Exception $ex) {
            return Array();
        }
    }

    public function getProduct($cod) {
        $cod = mysqli_real_escape_string($this->connection, $cod);
        $query = "CALL GetProduct('$cod')";

        $result = mysqli_query($this->connection, $query);

        $product = mysqli_fetch_object($result);
        mysqli_free_result($result);

        return $product;
    }

    public function createCartItemsContainer($customerId) {
        try{
            $customerId = mysqli_real_escape_string($this->connection, $customerId);

            $query = "CALL CreateCartItemsContainer('$customerId')";
            
            $result = mysqli_query($this->connection, $query);
            $containerId = mysqli_fetch_assoc($result);
            
            mysqli_free_result($result);
            mysqli_next_result($this->connection);

            return $containerId;
        } catch(mysqli_sql_exception  $ex) {
            if ($ex->getSQLState() === "45005") {
                return array("error" => true, "customerNotFound" => true);
            } else {
                return array("error" => true);
            }
        } catch(Exception $ex) {
            return array("error" => true);
        }
    }

    public function getItemsContainer($containerId) {
        try{
            $containerId = 1; //mysqli_real_escape_string($this->connection, $containerId);

            $query = "CALL GetItemsContainer('$containerId')";
            
            $result = mysqli_query($this->connection, $query);
            $lineItems = array();
            while ($row = mysqli_fetch_assoc($result)) {
                $lineItems[] = $row;
            }

            mysqli_free_result($result);
            mysqli_next_result($this->connection);

            return $lineItems;
        } catch(Exception $ex) {
            return array("error" => true);
        }
    }

    public function addProductToWishlist($customerID, $productID) {
        $customerID = mysqli_real_escape_string($this->connection, $customerID);
        $productID = mysqli_real_escape_string($this->connection, $productID);
        $query = "CALL AddProductToWishlist('$customerID', '$productID')";

        $result = mysqli_query($this->connection, $query);
    }

    public function getWishlistProducts($customerID) {
        $customerID = mysqli_real_escape_string($this->connection, $customerID);
        $query = "CALL GetWishlistProducts('$customerID')";

        $result = mysqli_query($this->connection, $query);
        
        $products = Array();
        while ($row = mysqli_fetch_object($result)) {
            $products[] = $row;
        }
        mysqli_free_result($result);

        return $products;
    }
}

?>