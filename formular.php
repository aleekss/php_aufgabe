<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Formular</title>
</head>
<body>

<h1> Anmeldung</h1>

<form action="formular.php" method="POST">
    <p>Titel: <input type="text" name="titel"></p>
    <p>Vorname: <input type="text" name="vorname"></p>
    <p>Nachname: <input type="text" name="nachname"></p>
    <p><input type="submit" value="Abschicken">
        <input type="reset" value="Zurücksetzen"></p>
</form>
<a href="sew_datenbank_v2/kunde.php" target="_blank">Kundenübersicht anzeigen</a><br>
<a href="sew_datenbank_v2/termin.php" target="_blank">Termin anlegen</a><br>





</body>
</html>



<?php
$servername = "localhost";
$username = "root";
$password = "";

try {
    $conn = new PDO("mysql:host=$servername;dbname=sew_datenbank_v2", $username, $password);
    echo "Connected successfully <br>";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}


$sql = "CREATE TABLE Kunde_v2(
    id integer primary key auto_increment,
    titel varchar(50),
    vorname varchar(50),
    nachname varchar(50)
)";

$sqlTermin =" CREATE TABLE Termin_v2(
     id integer primary key auto_increment,
    titel varchar(50),
    startdatum DATETIME,
    enddatum DATETIME,
    kunde_id integer, 
    foreign key(kunde_id) references Kunde_v2(id)
    
 )";

if ($_SERVER["REQUEST_METHOD"] === "POST"   ){
    $titel = $_POST['titel'];
    $vorname = $_POST['vorname'];
    $nachname = $_POST['nachname'];

    $sql = "INSERT INTO Kunde_v2(titel, vorname, nachname) VALUES (:titel, :vorname, :nachname)";
    $stmt = $conn->prepare($sql);

    $stmt->bindParam(':titel', $titel);
    $stmt->bindParam(':vorname', $vorname);
    $stmt->bindParam(':nachname', $nachname);

    $stmt->execute();

    $stmt = $conn->prepare("ALTER TABLE Kunde_v2 AUTO_INCREMENT = 1");
    $stmt->execute();

    $sqlInsertTermin = "INSERT INTO Termin_v2 (titel, startdatum, enddatum, kunde_id) VALUES (:titel, :startdatum, :enddatum, :kunde_id)";
    $stmtInsertTermin = $conn->prepare($sqlInsertTermin);

    $stmtInsertTermin->bindParam(':titel', $terminTitel);
    $stmtInsertTermin->bindParam(':startdatum', $startdatum);
    $stmtInsertTermin->bindParam(':enddatum', $enddatum);
    $stmtInsertTermin->bindParam(':kunde_id', $lastKundeId);

    $stmtInsertTermin->execute();

}












?>
