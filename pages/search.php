<?php
require_once '../classes/ProductMgr.php';
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/search.css");
?>

<?php include("../includes/header.php"); ?>

<div id="search">
    <?php
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
        $ProductMgr = new ProductMgr();
        $products = $ProductMgr->getProducts($category);
        
        foreach ($products as $product) {
            ?>
            <div class="product">
                <img src=<?php echo "https://picsum.photos/600?$product->id"; ?> alt="<?php echo $product->name; ?>">
                <div class="info">
                    <span class="title"><?php echo $product->name; ?></span>
                    <span class="price"><?php echo $product->price; ?></span>
                    <div class="details">
                        <span class="code"><?php echo $product->cod; ?></span>
                        &#8226;
                        <span class="category"><?php echo $product->category->name; ?></span>
                    </div>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>

<?php include("../includes/footer.php"); ?>
