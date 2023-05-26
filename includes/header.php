<?php
    require_once '../classes/AssetMgr.php';
    AssetMgr::addCss("/css/header.css");
?>

<?php include("head.php"); ?>
<header>
    <div class="top-bar">
        <div class="container">
            <div class="logo">
                <a href="#">Logo</a>
            </div>
            <div class="search-bar">
                <input type="text" placeholder="Search">
                <button type="submit">Search</button>
            </div>
            <div class="user">
                <a href="/hw1/login">
                    <img src="/hw1/client/icons/user.svg" alt="User Icon">
                </a>
            </div>
            <div class="cart">
                <a href="#">
                    <img src="/hw1/client/icons/cart.svg" alt="Cart Icon">
                </a>
            </div>
        </div>
    </div>
    <div class="bottom-bar">
        <div class="container">
        <ul class="categories">
            <?php
            require_once '../classes/ProductMgr.php';
            $productMgr = new ProductMgr();
            $categories = $productMgr->getCategories();
            foreach ($categories as $category) {
                echo "<li><a href=$category->url> $category->name </a></li>";
            }
            ?>
        </ul>
        </div>
    </div>
</header>
<main>