<?php
require_once '../classes/ProductMgr.php';
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/product.css");
?>

<?php include("../includes/header.php"); ?>

<div id="product">
    <?php
        if (isset($_GET['id'])) {
            $productId = $_GET['id'];
            $ProductMgr = new ProductMgr();
            $product = $ProductMgr->getProduct($productId);
                ?>
                <div class="image">
                        <img src=<?php echo "https://picsum.photos/id/$product->id/600"?> alt="<?php echo $product->name; ?>">
                </div>
                <div class="detail">
                    <h1 class="name"><?php echo $product->name; ?></h1>
                    <div class="info">
                    <span class="code"><?php echo $product->cod; ?></span> - <span class="category"><?php echo $product->category->name; ?></span>
                    </div>
                    <div class="price"><?php echo $product->price; ?></div>
                    <button class="add-to-cart">Aggiungi al Carrello</button>
                </div>
            <?php
        }
    ?>
</div>

<?php include("../includes/footer.php"); ?>