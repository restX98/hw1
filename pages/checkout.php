<?php
require_once '../classes/BasketMgr.php';
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/checkout.css");
AssetMgr::addJs("/js/checkout.js");

$currentBasket = BasketMgr::getCurrentBasket();
?>

<?php include("../includes/checkoutHeader.php"); ?>

<div id="checkout">
    <form class="address-form" method="POST">
        <div class="address">
            <h1>Checkout</h1>
            <div class="address-group">
                <input type="text" name="street" id="street-input" placeholder="Via/Piazza">
                <div id="street-error" class="error-message"></div>
                
                <input type="text" name="houseNumber" id="houseNumber-input" placeholder="Numero civico">
                <div id="houseNumber-error" class="error-message"></div>
                
                <input type="text" name="postalCode" id="postalCode-input" placeholder="CAP">
                <div id="postalCode-error" class="error-message"></div>
                
                <input type="text" name="city" id="city-input" placeholder="Città">
                <div id="city-error" class="error-message"></div>
                
                <input type="text" name="province" id="province-input" placeholder="Provincia">
                <div id="province-error" class="error-message"></div>
                
                <input type="text" name="country" id="country-input" placeholder="Paese">
                <div id="country-error" class="error-message"></div>
            </div>
        </div>
        <div class="summary">
            <h2>Riepilogo</h2>
            <p>
                Totale (<span class="total-quantity"><?php echo $currentBasket->totalQuantity ?></span>
                articoli): <span class="total-price"><?php echo "€ $currentBasket->totalPrice"; ?></span>
            </p>
            <button type="submit" class="continue-button" >
                Concludi l'ordine
            </button>
        </div>
    </form>
</div>