<?php
require_once '../classes/BasketMgr.php';
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/cart.css");

$currentBasket = BasketMgr::getCurrentBasket();
?>

<?php include("../includes/header.php"); ?>

<div id="cart">
    <div class="items">
    <h1>Carrello</h1>
    <ul>
        <?php foreach ($currentBasket->items as $item) { ?>
        <li>
            <img class="product-image" src=<?php echo $item->image; ?> alt=<?php echo $item->name; ?>>
            <div class="product-details">
                <h3><?php echo $item->name; ?></h3>
                <p>Prezzo: <?php echo "€ $item->price x $item->quantity"; ?></p>
            </div>
            <button class="remove-button">
                <img src="/hw1/client/icons/remove.svg" alt="Logout Icon">
            </button>
        </li>
        <?php } ?>
    </ul>
    </div>
  
    <div class="summary">
        <h2>Riepilogo</h2>
        <p>Totale (<?php echo $currentBasket->totalQuantity ?> articoli): <?php echo "€ $currentBasket->totalPrice"; ?></p>
        <button class="continue-button">Procedi all'ordine</button>
    </div>
</div>