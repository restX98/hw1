<?php
    require_once '../classes/AssetMgr.php';
    AssetMgr::addCss("/css/header.css");
?>

<?php include("head.php"); ?>
<header>
    <div class="top-bar">
        <div class="container">
            <div class="logo">
                <a href="/hw1">Logo</a>
            </div>
            <div class="separator">
            </div>
            <div class="user icon">
                <a href="/hw1/profile">
                    <img src="/hw1/client/icons/user.svg" alt="User Icon">
                </a>
            </div>
            <div class="cart icon">
                <a href="/hw1/cart">
                    <img src="/hw1/client/icons/cart.svg" alt="Cart Icon">
                </a>
            </div>
            <div class="logout icon">
                <a href="/hw1/logout">
                    <img src="/hw1/client/icons/logout.svg" alt="Logout Icon">
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