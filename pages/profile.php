<?php
require_once '../classes/CustomerMgr.php';
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/profile.css");
$customer = CustomerMgr::getCurrentCustomer();

if ($customer === null) {
    header("Location: login");
    exit();
}
?>

<?php include("../includes/header.php"); ?>

<div class="profile">
  <div class="personal-info">
    <h2>Dati personali</h2>
    <div class="info-row">
      <label for="name">Nome:</label>
      <span id="name"><?php echo $customer->firstName; ?></span>
    </div>
    <div class="info-row">
      <label for="surname">Cognome:</label>
      <span id="surname"><?php echo $customer->lastName; ?></span>
    </div>
    <div class="info-row">
      <label for="email">Email:</label>
      <span id="email"><?php echo $customer->email; ?></span>
    </div>
    <div class="info-row">
      <label for="phone">Telefono:</label>
      <span id="phone"><?php echo $customer->phoneNumber; ?></span>
    </div>
  </div>

  <div class="orders">
    <h2>Ordini</h2>
    <ul class="order-list">
      <li>Ordine 1</li>
      <li>Ordine 2</li>
      <li>Ordine 3</li>
    </ul>
  </div>

  <div class="addresses">
    <h2>Indirizzi</h2>
    <ul class="address-list">
      <li>Indirizzo 1</li>
      <li>Indirizzo 2</li>
      <li>Indirizzo 3</li>
    </ul>
  </div>
</div>
