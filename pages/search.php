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
                <a href=<?php echo $product->url; ?>>
                    <img src=<?php echo "https://picsum.photos/id/$product->id/600"?> alt="<?php echo $product->name; ?>">
                </a>
                <div class="info">
                    <a href=<?php echo $product->url; ?>>
                        <span class="title">
                                <?php echo $product->name; ?>
                        </span>
                    </a>
                    <span class="price"><?php echo $product->price; ?></span>
                    <div class="details">
                        <span class="code"><?php echo $product->cod; ?></span>
                        &#8226;
                        <span class="category"><?php echo $product->category->name; ?></span>
                    </div>
                    <button class="add-button">
                        <img src="/hw1/client/icons/add.svg" alt="Logout Icon">
                    </button>
                </div>
            </div>
            <?php
        }
    }
    ?>
</div>

<?php include("../includes/footer.php"); ?>
