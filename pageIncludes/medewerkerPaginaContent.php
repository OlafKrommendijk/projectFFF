<?php

?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/medewerkerPagina.css">
</head>
<body>

<div id="page-wrapper">

    <div class="buttonBox">
        <a href="./medewerkerPagina.php" class="myButton">Korting</a>
        <a href="./lijsten.php" class="myButton">Lijsten</a>
        <a href="./bestellingenRetour.php" class="myButton">Bestellingen / retour</a>
    </div>


    <div class="emailDiscount">
        <form name="geefKorting" method="POST" enctype="multipart/form-data" action=" ">
            Email:<br>
            <input required type="email" name="email" placeholder="bij@voorbeeld.com"  />
            <br>


            Korting in %:<br>
            <select>
                <option value="5">5%</option>
                <option value="10">10%</option>
                <option value="15">15%</option>
                <option value="20">20%</option>
                <option value="25">25%</option>
                <option value="30">30%</option>
                <option value="35">35%</option>
                <option value="40">40%</option>
                <option value="45">45%</option>
                <option value="50">50%</option>
                <option value="55">55%</option>
                <option value="60">60%</option>
                <option value="65">65%</option>
                <option value="70">70%</option>
                <option value="75">75%</option>
                <option value="80">80%</option>
                <option value="85">85%</option>
                <option value="90">90%</option>
                <option value="95">95%</option>

            </select>
            <br><br>

            <input type="hidden" name="submit" value="true" />
            <input type="submit" id="submit" value=" Korting Geven! " />
        </form>
    </div>


</div>
</body>
</html>

<?php
?>