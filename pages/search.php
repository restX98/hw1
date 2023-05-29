<?php
require_once '../classes/CustomerMgr.php';
$currentCustomer = CustomerMgr::getCurrentCustomer();

if (is_null($currentCustomer)) {
    header("Location: /hw1/login");
    exit();
}

require_once '../classes/ProductMgr.php';
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/search.css");
AssetMgr::addJs("/js/product.js");
?>

<?php include("../includes/header.php"); ?>

<div id="server-error" class="error-message server-error"></div>

<div id="search">
    <?php
    if (isset($_GET['category'])) {
        $category = $_GET['category'];
        $ProductMgr = new ProductMgr();
        $products = $ProductMgr->getProducts($category);
        
        foreach ($products as $product) {
            ?>
            <div class="product" data-product=<?php echo $product->cod; ?> data-name=<?php echo $product->name; ?>
                 data-price=<?php echo $product->price; ?> data-category=<?php echo $product->category->cod; ?> >
                <a href=<?php echo $product->url; ?>>
                    <img src=<?php echo $product->image; ?> alt="<?php echo $product->name; ?>">
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
                    <button class="add-to-cart">
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
