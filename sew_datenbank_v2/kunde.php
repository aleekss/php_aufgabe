<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Kundenübersicht</title>
</head>
<body>
<h2>Kundenübersicht</h2>
<a href="termin.php" target="_blank">Termin anlegen</a>
<br>
<a href="formular.php" target="_blank">Anmeldung Termin</a>



<?php
try {
    $dbh = new PDO('mysql:host=localhost;dbname=sew_datenbank_v2', 'root', '');
    echo "Connected successfully <br>";
} catch(PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

$sql3 = "SELECT * FROM Kunde_v2";
$query = $dbh->query($sql3);
$result = $query->fetchAll();

echo "<table border='2'>";
echo "<tr><th>Titel</th><th>Vorname</th><th>Nachname</th></tr>";

foreach($result as $row) {
    echo "<tr>";

    echo "<td>" . $row['titel'] . "</td>";
    echo "<td>" . $row['vorname'] . "</td>";
    echo "<td>" . $row['nachname'] . "</td>";
    echo "<td>";
    echo "<button class='edit-button' onclick='showEditForm(" . $row['id'] . ")'>Edit</button>";
    echo "<form id='edit-form-" . $row['id'] . "' method='POST' action='".$_SERVER['PHP_SELF']."' style='display:none;'>";
    echo "<input type='hidden' name='editId' value='" . $row['id'] . "'>";
    echo "<input type='text' name='editTitel' value='" . $row['titel'] . "'>";
    echo "<input type='text' name='editVorname' value='" . $row['vorname'] . "'>";
    echo "<input type='text' name='editNachname' value='" . $row['nachname'] . "'>";
    echo "<button type='submit'>Save</button>";
    echo "</form>";
    echo "<form method='POST' action='".$_SERVER['PHP_SELF']."' style='display:inline;'>";
    echo "<input type='hidden' name='deleteId' value='" . $row['id'] . "'>";
    echo "<button type='submit'>Delete</button>";
    echo "</form>";
    echo "</td>";
    echo "</tr>";

}

echo "</table>";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["editId"])) {
        $editId = $_POST["editId"];
        $editTitel = $_POST["editTitel"];
        $editVorname = $_POST["editVorname"];
        $editNachname = $_POST["editNachname"];

        $sqlUpdate = "UPDATE Kunde_v2 SET titel = :titel, vorname = :vorname, nachname = :nachname WHERE id = :id";
        $stmt = $dbh->prepare($sqlUpdate);
        $stmt->bindParam(':titel', $editTitel);
        $stmt->bindParam(':vorname', $editVorname);
        $stmt->bindParam(':nachname', $editNachname);
        $stmt->bindParam(':id', $editId);
        $stmt->execute();

        header("Location: ".$_SERVER['PHP_SELF']);
    }

    if (isset($_POST["deleteId"])) {
        $deleteId = $_POST["deleteId"];

        $sqlDelete = "DELETE FROM Kunde_v2 WHERE id = :id";
        $stmt = $dbh->prepare($sqlDelete);
        $stmt->bindParam(':id', $deleteId);
        $stmt->execute();

        header("Location: ".$_SERVER['PHP_SELF']);
    }
}
?>

<script>
    function showEditForm(id) {
        var editForm = document.getElementById('edit-form-' + id);
        if (editForm.style.display === 'none') {
            editForm.style.display = 'table-row';
        } else {
            editForm.style.display = 'none';
        }
    }
</script>

</body>
</html>
