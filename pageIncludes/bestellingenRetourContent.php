<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/bestellingenRetour.css">
</head>


<div id="page-wrapper">
    <?php
    //controleert of de persoon wel bevoegd is om dit te zien
    if (isset($_SESSION["admin"]) && $_SESSION["STATUS"] === 1) {
    ?>
    <div class="buttonBox">
        <a href="./medewerkerPagina.php" class="myButton">Korting</a>
        <a href="./lijsten.php" class="myButton">Lijsten</a>
        <a href="./bestellingenRetour.php" class="myButton">Bestellingen / retour</a>
    </div>
    <?php
    }   ?>
</div>
</html>

<?php
//checkt of er een medewerker in logt
if (isset($_SESSION["admin"]) && $_SESSION["STATUS"] === 1 ){
    //de dag van vandaag
    $dateNow = date('Y-m-d');

    //query die alle orders van vandaag ophaalt
    $query = "SELECT * FROM orders 
              INNER JOIN orderregel ON orderRegel_orderID = ordersID 
              INNER JOIN klant ON orders_klantID = klantID  
              WHERE retourDatum = '$dateNow' AND bezorgen = 0
              OR bestelDatum = '$dateNow' AND bezorgen = 0 
              GROUP BY ordersID;";

    //prepared de query en voert hem uit
    $stmt = $db->prepare($query);
    $stmt->execute(array());
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    //Gaat met een foreach over alle orders en laat ze zien
    foreach ($result as $id => $order) {
        echo '<div class="order"><pre class="tab">';
        echo "Factuurnummer: " . $order['ordersID'] . "     Voornaam: " . $order['naam'] . "    Achternaam: " . $order['achternaam'];
        echo '<div class="betaald"><form class="orderForm" method="POST" enctype="multipart/form-data">';
        if ($order["betaald"] == 0) {
            echo 'Betaald <input type="checkbox" name="unchecked" value="unchecked" onchange="this.form.submit()"><input type="hidden" name="id" value="'.$order['ordersID'].'">';
       }
        else {
            echo 'Betaald <input type="checkbox" checked name="checked" value="checked" onchange="this.form.submit()"><input type="hidden" name="id" value="'.$order["ordersID"].'"><input type="hidden" name="test" value="checked">';
        }

        if($order["afgeleverd"] == 0){
            echo 'Opgehaald <input type="checkbox" name="uncheckedBezorgd" value="uncheckedBezorgd" onchange="this.form.submit()"><input type="hidden" name="id" value="'.$order['ordersID'].'">';
        }else{
            echo 'Opgehaald <input type="checkbox" checked name="checked" value="checked" onchange="this.form.submit()"><input type="hidden" name="id" value="'.$order["ordersID"].'"><input type="hidden" name="test" value="checked">';
        }
        echo '</form></div>';
        echo '</div>';
        echo '</pre></div>';
    }
    //controleert of er een chauffeur inlogt
}else if ($_SESSION["STATUS"] === 2){
    //de dag van vandaag
    $dateNow = date('Y-m-d');

    //query die alle orders van vandaag ophaalt
    $query = "SELECT * FROM orders 
              INNER JOIN orderregel ON orderregel.orderRegel_orderID = orders.ordersID 
              INNER JOIN klant ON orders.orders_klantID = klant.klantID 
              INNER JOIN address ON orders.orders_addressID = address.addressID 
              WHERE retourDatum = '$dateNow' AND bezorgen = 1
              OR bestelDatum = '$dateNow' AND bezorgen = 1 
              GROUP BY ordersID ORDER BY postcode ASC;";
    $stmt = $db->prepare($query);
    $stmt->execute(array());
    $check = $stmt->fetchAll(PDO::FETCH_ASSOC);
    //splits de query in 3en zodat elke chauffeur een deel heeft
    $result = array_chunk($check, ceil(count($check) / 3));

    //controllert welke chauffeur inlogt
    if ($_SESSION["email"] === 'chauffeur1@gmail.com'){
        $result = $result[0];
    }elseif ($_SESSION["email"] === 'chauffeur2@gmail.com'){
        $result = $result[1];
    }elseif ($_SESSION["email"] === 'chauffeur3@gmail.com') {
        $result = $result[2];
    }

    //Gaat met een foreach over alle orders en laat ze zien
    foreach ($result as $id => $order) {
        echo '<div class="order"><pre class="tab">';
        echo "Factuurnummer: " . $order['ordersID'] . "     Voornaam: " . $order['naam'] . "    Achternaam: " . $order['achternaam'];
        echo '<div class="betaald"><form class="orderForm" method="POST" enctype="multipart/form-data">';
        if ($order["betaald"] == 0) {
            echo 'Betaald <input type="checkbox" name="unchecked" value="unchecked" onchange="this.form.submit()"><input type="hidden" name="id" value="'.$order['ordersID'].'">';
        }
        else {
            echo 'Betaald <input type="checkbox" checked name="checked" value="checked" onchange="this.form.submit()"><input type="hidden" name="id" value="'.$order["ordersID"].'"><input type="hidden" name="test" value="checked">';
        }

        if($order["afgeleverd"] == 0){
            echo 'Afgeleverd <input type="checkbox" name="uncheckedBezorgd" value="uncheckedBezorgd" onchange="this.form.submit()"><input type="hidden" name="id" value="'.$order['ordersID'].'">';
        }else{
            echo 'Afgeleverd <input type="checkbox" checked name="checked" value="checked" onchange="this.form.submit()"><input type="hidden" name="id" value="'.$order["ordersID"].'"><input type="hidden" name="test" value="checked">';
        }
        echo '</form></div>';
        echo '</div>';
        echo '</pre></div>';
    }

}else{
    header("Location: http://localhost/projectFFF/index.php");
}

//Als er op de checkbox wordt gedrukt is het product betaald
if (isset($_POST['unchecked'])){
    $orderID = $_POST['id'];

    $query = "UPDATE orders SET betaald = '1' WHERE ordersID = '$orderID'";
    $stmt = $db->prepare($query);
    $stmt->execute(array());

    header('Refresh:0');
    exit;
}
if (isset($_POST['uncheckedBezorgd'])){
    $orderID = $_POST['id'];

    $query = "UPDATE orders SET afgeleverd = '1' WHERE ordersID = '$orderID'";
    $stmt = $db->prepare($query);
    $stmt->execute(array());

    header('Refresh:0');
    exit;
}