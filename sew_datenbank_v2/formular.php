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
<a href="kunde.php"> Kundenübersicht</a>


</body>
</html>


<?php

try{
    $dbh = new PDO('mysql:host=localhost;dbname=sew_datenbank_v2', 'root', '');

    echo "Verbunden";

    $sqlKunde = "CREATE TABLE if not exists Kunde_v2(
    id integer primary key,
    titel varchar(50),
    vorname varchar(50),
    nachname varchar(50)
)";

$sqlTermin = "Create Table if not exists Termin_v2(
    id integer primary key, 
    titel varchar(50),
    startDatum datetime,
    endDatum datetime, 
    startZeit time, 
    endZeit time, 
    kunde_id integer, 
    
    foreign key (kunde_id) references Kunde_v2(id)
    

)";



    $dbh->exec($sqlKunde);
    $dbh->exec($sqlTermin);

    if ($_SERVER["REQUEST_METHOD"] === "POST"   ) {
        $titel = $_POST['titel'];
        $vorname = $_POST['vorname'];
        $nachname = $_POST['nachname'];

        $sql = "INSERT INTO Kunde_v2(titel, vorname, nachname) VALUES (:titel, :vorname, :nachname)";
        $stmt = $dbh->prepare($sql);

        $stmt->bindParam(':titel', $titel);
        $stmt->bindParam(':vorname', $vorname);
        $stmt->bindParam(':nachname', $nachname);

        $stmt->execute();

    }


}catch(PDOException $e){
    echo "Error: " . $e->getMessage();

}

var_dump($dbh->errorInfo());
$dbh = null;



?>