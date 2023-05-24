<?php 
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/login.css");
?>
<?php include("../includes/noHeader.php"); ?>
<div id="login">
    <div class="container">
        <form class="login-form">
            <h1>Login</h1>
            <input type="email" placeholder="Email" required>
            <input type="password" placeholder="Password" required>
            <button type="submit">Login</button>
            <p class="forgot-password">Forgot password?</p>
            <div class="register-link">
                <p>Don't have an account? <a href="#">Register</a></p>
            </div>
        </form>
    </div>
</div>