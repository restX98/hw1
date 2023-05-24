<?php include("../includes/header.php"); ?>
    <h1>Effettua il login</h1>
    <form action="" method="post">
        <label for="email">Indirizzo email:</label>
        <input type="email" id="email" name="email" required><br><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br><br>
        <button type="submit" name="login">Accedi</button>
    </form>
<?php include("../includes/footer.php"); ?>