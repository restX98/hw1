<?php
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/cart.css");
?>

<?php include("../includes/header.php"); ?>

<div id="cart">
  <div class="items">
    <h1>Carrello</h1>
    <ul>
      <li>
        <img class="product-image" src="https://picsum.photos/500/" alt="Product 1">
        <div class="product-details">
          <h3>Product 1</h3>
          <p>Prezzo: €10.00</p>
        </div>
        <button class="remove-button">
          <img src="/hw1/client/icons/remove.svg" alt="Logout Icon">
        </button>
      </li>
      <li>
        <img class="product-image" src="https://picsum.photos/500/" alt="Product 1">
        <div class="product-details">
          <h3>Product 1</h3>
          <p>Prezzo: €10.00</p>
        </div>
        <button class="remove-button">
          <img src="/hw1/client/icons/remove.svg" alt="Logout Icon">
        </button>
      </li>
    </ul>
  </div>
  
  <div class="summary">
    <h2>Riepilogo</h2>
    <p>Totale (2 articoli): €25.00</p>
    <button class="continue-button">Procedi all'ordine</button>
  </div>
</div>