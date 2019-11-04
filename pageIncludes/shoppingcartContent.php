<?php
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/shoppingcart.css">
</head>
<body>

<div class="page-wrapper">
    <div class="shoppingcartProducts">
        <?php
        if (isset($_SESSION['cart'] )) {
            foreach ($_SESSION['cart'] as $pId => $items) {
                echo '<div class="product">';
                echo '<div class="productAfbeelding"><img src="' . $items['pImage'] . '" alt="Productafbeelding"></div><pre class="tab">' . ' ' . $items['pName'] .  '        ' . $items['pStartDate'] . '     ' . $items['pEndDate'] . '     €' . $items['price'] . '       €' .$items['priceTotal'];
                echo '</form></div>';
            }
        }else{
            echo 'Er zit geen product in uw winkelwagen';
        }
    ?>
    </div>

    <form id="cartForm" method="POST" enctype="multipart/form-data">
        <input class="shoppingcartInput" type="email" name="email" placeholder="Email"> Email<br>
        <input class="shoppingcartInput" type="text" name="firstname" placeholder="Naam"> Naam<br>
        <input class="shoppingcartInput" type="text" name="tussenvoegsel" placeholder="Tussenvoegsel"> Tussenvoegsel<br>
        <input class="shoppingcartInput" type="text" name="lastname" placeholder="Achternaam"> Achternaam<br>
        <input class="shoppingcartInput" type="text" name="street" placeholder="Straatnaam"> Straatnaam<br>
        <input class="shoppingcartInput" type="number" name="number" placeholder="Huisnummer"> Huisnummer<br>
        <input class="shoppingcartInput" type="text" name="postal" placeholder="Postcode"> Postcode<br>
        <input class="shoppingcartInput" type="text" name="city" placeholder="Stad"> Stad<br>
        <input class="shoppingcartInput" type="radio" name="bezorgen"> Bezorgkosten + €50,-
        <input type="submit" id="submit" name="submit" value="Koop/Reserveer">
    </form>
</div>
</html>

<?php
if (isset($_POST['submit'])) {
    $customerEmail = htmlspecialchars($_POST['email']);
    $customerFirstname = htmlspecialchars($_POST['firstname']);
    $customerBetween = htmlspecialchars($_POST['tussenvoegsel']);
    $customerLastname = htmlspecialchars($_POST['lastname']);
    $customerStreet = htmlspecialchars($_POST['street']);
    $customerNumber = htmlspecialchars($_POST['number']);
    $customerPostal = htmlspecialchars($_POST['postal']);
    $customerCity = htmlspecialchars($_POST['city']);

//    $customerDeliver = $_POST['bezorgen'];


    if (filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
        $checkedEmail = filter_var($customerEmail, FILTER_VALIDATE_EMAIL);
        $sql = "SELECT email FROM klant WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute(['email' => $customerEmail]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result > 0) {
//          Code voor als het email al in gebruik is
            $sql = "SELECT email FROM klant WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->execute(['email' => $customerEmail]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $klantId = $result['klantid'];


        } else {
            $query = "INSERT INTO klant (naam, tussenvoegsel, achternaam, email)  VALUES ('$customerFirstname', '$customerBetween', '$customerLastname', '$customerEmail')";
            $db->exec($query);

            if ($query) {
                $sql = "SELECT email FROM klant WHERE email = :email";
                $stmt = $db->prepare($sql);
                $stmt->execute(['email' => $customerEmail]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $klantId = $result['klantid'];

                $query = "INSERT INTO address (address_klantID, straat, huisnummer, postcode, woonplaats)  VALUES ('$klantId', '$customerStreet', '$customerNumber', '$customerPostal', '$customerCity')";
                $db->exec($query);
            }
        }
    }

    $query = "INSERT INTO 'order' (order_klantID)  VALUES ('$klantId')";
    $db->exec($query);

    foreach ($_SESSION['cart'] as $pId => $items) {
        $pId = $items['productId'];
        $pStartDate = $items['pStartDate'];
        $pEndDate = $items['pEndDate'];
        $pAmount = $items['pAmount'];

        $query = "SELECT orderId FROM 'order' WHERE order_klantID = '$result'";
        $stmt = $db->prepare($query);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $orderId = $result;

        $query = "INSERT INTO orderregel (orderRegel_artikelID, orderRegel_orderID, bestelDatum, retourDatum, aantal)  VALUES ('$pId', $orderId, '$pStartDate', '$pEndDate', '$pAmount')";
        $db->exec($query);
        }
}
?>


