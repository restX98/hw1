<?php
require_once '../classes/CustomerMgr.php';
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/profile.css");
$customer = CustomerMgr::getCurrentCustomer();

if (is_null($customer)) {
    header("Location: login");
    exit();
}
?>

<?php include("../includes/header.php"); ?>

<div id="profile">
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
    <?php
      $addresses = $customer->getAddresses();
    ?>
    <ul class="address-list">
    <?php
      foreach ($addresses as $address) {
          echo '<li>' . $address->toString() . '</li>';
      } 
    ?>
    </ul>
  </div>
</div>
