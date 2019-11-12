<?php
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/lijsten.css">
</head>
<body>

<div id="page-wrapper">

    <div class="buttonBox">
        <a href="./medewerkerPagina.php" class="myButton">Korting</a>
        <a href="./lijsten.php" class="myButton">Lijsten</a>
        <a href="./bestellingenRetour.php" class="myButton">Bestellingen / retour</a>
    </div>

    <div class="lijstBox">
        <form name="lijstSelect" method="POST" enctype="multipart/form-data" action=" ">
            Selecteer uw lijst:<br>
            <select name="select">
                <option value="medewerker">Medewerker</option>
                <option value="chaff1">Chauffeur 1</option>
                <option value="chaff2">Chauffeur 2</option>
                <option value="chaff3">Chauffeur 3</option>
                <option value="factuur">Factuur</option>
            </select>
            <br><br>
            <input type="submit" id="submit" name="submit" value="submit" />
        </form>
    </div>
</div>
</body>
</html>

<?php

if (isset($_POST['submit'])){
    if ($_POST['select'] === 'medewerker'){
        echo "<script>window.location = 'medewerkerLijst.php';</script>";
    }

    if ($_POST['select'] === 'chaff1'){
        echo "<script>window.location = 'chauffeurLijst.php?id=1';</script>";
    }
    if ($_POST['select'] === 'chaff2'){
        echo "<script>window.location = 'chauffeurLijst.php?id=2';</script>";
    }

    if ($_POST['select'] === 'chaff3'){
        echo "<script>window.location = 'chauffeurLijst.php?id=3';</script>";
    }


    if ($_POST['select'] === 'factuur'){
        echo "<script>window.location = 'factuur.php';</script>";
    }
}