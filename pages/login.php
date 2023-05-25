<?php
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/login.css");
AssetMgr::addJs("/js/login.js");

// Verifica se l'utente è già loggato
require_once '../classes/CustomerMgr.php';
$customerMgr = new CustomerMgr();
$currentCustomer = $customerMgr->getCurrentCustomer();

// Se l'utente è loggato, esegui il redirect alla home
if ($currentCustomer !== null) {
    header("Location: home"); // Sostituisci "home.php" con il percorso corretto per la home
    exit();
}
?>

<?php include("../includes/noHeader.php"); ?>
<div id="login">
    <div id="server-error" class="error-message server-error"></div>
    <div class="container">
        <form class="login-form" method="POST">
            <h1>Login</h1>
            <input type="text" name="email" id="email-input" placeholder="Email" >
            <div id="email-error" class="error-message"></div>
            <input type="password" name="password" id="password-input" placeholder="Password" >
            <div id="password-error" class="error-message"></div>
            <button type="submit">Login</button>
            <div class="register-link">
                <p>Non hai un account? <a href="#">Registrati</a></p>
            </div>
        </form>
    </div>
</div>