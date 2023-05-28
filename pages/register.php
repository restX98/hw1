<?php
require_once '../classes/AssetMgr.php';
AssetMgr::addCss("/css/register.css");
AssetMgr::addJs("/js/register.js");

require_once '../classes/CustomerMgr.php';
$customerMgr = new CustomerMgr();
$currentCustomer = $customerMgr::getCurrentCustomer();

if ($currentCustomer !== null) {
    header("Location: profile");
    exit();
}
?>

<?php include("../includes/noHeader.php"); ?>

<div id="register">
  <div id="server-error" class="error-message server-error"></div>
  <div class="container">
    <form class="register-form" method="POST">
        <h1>Crea un account</h1>
        
        <input type="text" name="firstName" id="first-name-input" placeholder="Nome">
        <div id="first-name-error" class="error-message"></div>
        
        <input type="text" name="lastName" id="last-name-input" placeholder="Cognome">
        <div id="last-name-error" class="error-message"></div>
        
        <input type="email" name="email" id="email-input" placeholder="Email">
        <div id="email-error" class="error-message"></div>

        <input type="text" name="phone" id="phone-input" placeholder="Numero di telefono">
        <div id="phone-error" class="error-message"></div>

        <input type="password" name="password" id="password-input" placeholder="Password">
        <div id="password-error" class="error-message"></div>

        <input type="password" name="confirmPassword" id="confirm-password-input" placeholder="Conferma password">
        <div id="confirm-password-error" class="error-message"></div>

        <button type="submit">Registrati</button>

        <div class="login-link">
            <p>Hai già un account? Effettua il <a href="/hw1/login">login</a></p>
        </div>
    </form>
  </div>
</div>
