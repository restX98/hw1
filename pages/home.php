<?php
require_once '../classes/CustomerMgr.php';
$currentCustomer = CustomerMgr::getCurrentCustomer();

if (is_null($currentCustomer)) {
    header("Location: login");
    exit();
}
?>
<?php include("../includes/header.php"); ?>
<h1>Home Page</h1>
<?php include("../includes/footer.php"); ?>
