<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/bestellingenRetour.css">
</head>
<div id="page-wrapper">
    <div class="buttonBox">
        <a href="./medewerkerPagina.php" class="myButton">Korting</a>
        <a href="./lijsten.php" class="myButton">Lijsten</a>
        <a href="./bestellingenRetour.php" class="myButton">Bestellingen / retour</a>
    </div>
</div>
</html>

<?php
if (isset($_SESSION["admin"]) && $_SESSION["STATUS"] === 1 ){
    $dateNow = date('Y-m-d');
    $query = "SELECT * FROM orders INNER JOIN orderregel ON orderRegel_orderID = ordersID INNER JOIN klant ON orders_klantID = klantID  WHERE retourDatum = '$dateNow' AND bezorgen = 0 OR bestelDatum = '$dateNow' AND bezorgen = 0 GROUP BY ordersID;";
    $stmt = $db->prepare($query);
    $stmt->execute(array());
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    foreach ($result as $id => $order) {
        echo '<div class="order"><pre class="tab">';
        echo "Factuurnummer: " . $order['ordersID'] . "     Voornaam: " . $order['naam'] . "    Achternaam: " . $order['achternaam'];
        echo '<div class="betaald"><form class="orderForm" method="POST" enctype="multipart/form-data">';
        if ($order["betaald"] == 0) {
            echo 'Betaald <input type="checkbox" name="unchecked" value="unchecked" onchange="this.form.submit()"><input type="hidden" name="id" value="'.$order['ordersID'].'">';}
        else {
            echo 'Betaald <input type="checkbox" checked name="checked" value="checked" onchange="this.form.submit()"><input type="hidden" name="id" value="'.$order["ordersID"].'"><input type="hidden" name="test" value="checked">';
        }
        echo '</form></div>';
        echo '</div>';
        echo '</pre></div>';
    }

    if (isset($_POST['unchecked'])){
        $orderID = $_POST['id'];

        $query = "UPDATE orders SET betaald = '1' WHERE ordersID = '$orderID'";
        $stmt = $db->prepare($query);
        $stmt->execute(array());

        header('Refresh:0');
        exit;
    }
}

