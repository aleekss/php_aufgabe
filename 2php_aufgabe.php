<?php
require_once "formular.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formular</title>
</head>
<body>

<h1>Anmeldung</h1>
<form action="formular.php" method="POST">
    <p>Titel: <input type="text" name="titel"></p>
    <p>Vorname: <input type="text" name="vorname"></p>
    <p>Nachname: <input type="text" name="nachname"></p>
    <p><input type="submit" value="Abschicken">
        <input type="reset" value="Zurücksetzen"></p>
</form>

</body>
</html>


