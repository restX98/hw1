<?php
require_once '../classes/BasketMgr.php';
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/cart.css");
AssetMgr::addJs("/js/product.js");
AssetMgr::addJs("/js/cart.js");

$currentBasket = BasketMgr::getCurrentBasket();
?>

<?php include("../includes/checkoutHeader.php"); ?>

<div id="server-error" class="error-message server-error"></div>

<div id="cart">
    <div class="items">
        <h1>Carrello</h1>
        <ul>
            <?php foreach ($currentBasket->items as $item) { ?>
            <li class="product" data-product=<?php echo $item->cod; ?> data-name=<?php echo $item->name; ?>
                data-price=<?php echo $item->price; ?> data-category=<?php echo $item->category->cod; ?> >
                <img class="product-image" src=<?php echo $item->image; ?> alt=<?php echo $item->name; ?>>
                <div class="product-details">
                    <h3><?php echo $item->name; ?></h3>
                    <p>
                        Prezzo:
                        <?php echo "€ <span class='price'>$item->price</span> x <span class='quantity'>$item->quantity</span>"; ?>
                    </p>
                </div>
                <button class="remove-from-cart">
                    <img src="/hw1/client/icons/remove.svg" alt="Logout Icon">
                </button>
            </li>
            <?php } ?>
        </ul>
    </div>
  
    <div class="summary">
        <h2>Riepilogo</h2>
        <p>
            Totale (<span class="total-quantity"><?php echo $currentBasket->totalQuantity ?></span>
            articoli): <span class="total-price"><?php echo "€ $currentBasket->totalPrice"; ?></span>
        </p>
        <a href="/hw1/checkout" class="continue-button <?php echo $currentBasket->totalPrice > 0 ? "" : "disabled"?>" >
            Procedi al checkout
        </a>
    </div>
</div>