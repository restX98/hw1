<?php
require_once '../classes/CustomerMgr.php';
$customerMgr = new CustomerMgr();
$customerMgr::logoutCustomer();

header("Location: login");
exit();
?>
