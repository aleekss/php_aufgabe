<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Termin</title>
</head>
<body>

<h1>Termin anlegen</h1>

<form action="termin.php" method="POST">
    <p>Titel: <input type="text" name="titel"></p>
    <label for="startdatum">Von:</label>
    <input type="date" name="startdatum" >
    <input type="time" name="startZeit" >
<br>
    <label for="enddatum">Bis:</label>
    <input type="date" name="enddatum" >
    <input type="time" name="endZeit" >
<br>
    <label for="kunde_id">Kunde: </label>
    <select name="kunde_id">
        <?php
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbh = new PDO("mysql:host=$servername;dbname=sew_datenbank_v2", $username, $password);
        $sqlKunde = "SELECT id, CONCAT(vorname, ' ', nachname) AS kunde_name FROM Kunde_v2";
        $queryKunde = $dbh->query($sqlKunde);
        $resultKunde = $queryKunde->fetchAll();

        foreach ($resultKunde as $kunde) {
        echo "<option value='" . $kunde['id'] . "'>" . $kunde['kunde_name'] . "</option>";
        }
        ?>
    </select>
<br>
    <p><input type="submit" value="Termin anlegen"></p>
</form>
<a href="kunde.php" target="_blank">Kundenübersicht anzeigen</a>






</body>
</html>


<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $dbh = new PDO("mysql:host=$servername;dbname=sew_datenbank_v2", $username, $password);
    echo "Connected successfully <br>";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $terminTitel = $_POST['titel'];
    $startdatum = $_POST['startdatum'] . ' ' . $_POST['startZeit'];
    $enddatum = $_POST['enddatum'] . ' ' . $_POST['endZeit'];

    $sqlInsertTermin = "INSERT INTO Termin_v2 (titel, startdatum, enddatum, kunde_id) VALUES (:titel, :startdatum, :enddatum, :kunde_id)";
    $stmtInsertTermin = $dbh->prepare($sqlInsertTermin);

    $stmtInsertTermin->bindParam(':titel', $terminTitel);
    $stmtInsertTermin->bindParam(':startdatum', $startdatum);
    $stmtInsertTermin->bindParam(':enddatum', $enddatum);
    $stmtInsertTermin->bindParam(':kunde_id', $_POST['kunde_id']);

    $stmtInsertTermin->execute();
}
?>