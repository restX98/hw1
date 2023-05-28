<?php
require_once '../classes/ProductMgr.php';
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/product.css");
AssetMgr::addJs("/js/product.js");

if (!isset($_GET['id'])) {
    header("Location: home");
    exit();
} else {
    $productId = $_GET['id'];
    $ProductMgr = new ProductMgr();
    $product = $ProductMgr->getProduct($productId);

    if(is_null($product)) {
        header("Location: /hw1/");
        exit();
    }
}
?>

<?php include("../includes/header.php"); ?>

<div id="server-error" class="error-message server-error"></div>

<div id="product" data-product=<?php echo $product->cod; ?> data-name=<?php echo $product->name; ?> 
     data-price=<?php echo $product->price; ?> data-category=<?php echo $product->category->cod; ?>>
    <div class="image">
            <img src=<?php echo $product->image; ?> alt="<?php echo $product->name; ?>">
    </div>
    <div class="detail">
        <h1 class="name"><?php echo $product->name; ?></h1>
        <div class="info">
        <span class="code"><?php echo $product->cod; ?></span> - <span class="category"><?php echo $product->category->name; ?></span>
        </div>
        <div class="price"><?php echo $product->price; ?></div>
        <button class="add-to-cart">Aggiungi al Carrello</button>
    </div>
</div>

<?php include("../includes/footer.php"); ?>