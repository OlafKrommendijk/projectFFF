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
        <input type="submit" id="submit" name=submit" value="Koop/Reserveer">
    </form>
</div>
</html>

<?php
if (isset($_POST['submit'])){
    $message = "hallo";
    echo "<script type='text/javascript'>alert('$message');</script>";

    $customerEmail = htmlspecialchars($_POST['email']);
    $customerFirstname = htmlspecialchars($_POST['firstname']);
    $customerBetween = htmlspecialchars($_POST['tussenvoegsel']);
    $customerLastname = htmlspecialchars($_POST['lastname']);
    $customerStreet = htmlspecialchars($_POST['street']);
    $customerNumber = htmlspecialchars($_POST['number']);
    $customerPostal = htmlspecialchars($_POST['postal']);
    $customerCity = htmlspecialchars($_POST['city']);
    $customerDeliver = $_POST['bezorgen'];

    $message = "$customerEmail";
    echo "<script type='text/javascript'>alert('$message');</script>";

    if (filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
        $checkedEmail = filter_var($customerEmail, FILTER_VALIDATE_EMAIL);
        $sql = "SELECT email FROM gebruiker WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute(['email' => $customerEmail]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $_SESSION["email"] = $customerEmail;

        $message = $result . $_SESSION['email'];
        echo "<script type='text/javascript'>alert('$message');</script>";

        if ($result > 0) {
//          Code voor als het email al in gebruik is
            $message = "Bestaat";
            echo "<script type='text/javascript'>alert('$message');</script>";
        } else{
            $query = "INSERT INTO klant (naam, tussenvoegsel, achternaam, email)  VALUES ('$customerFirstname', '$customerBetween', '$customerLastname', '$customerEmail')";
            $stmt = $db->prepare($query);
            $db->exec($stmt);

            $query = "INSERT INTO address (straat, huisnummer, postcode, woonplaats)  VALUES ('$customerStreet', '$customerNumber', '$customerPostal', '$customerCity')";
            $stmt = $db->prepare($query);
            $db->exec($stmt);

            $message = "3";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }

        $query = "INSERT INTO 'order' (order_klantID)  VALUES ('$klantId')";
        $stmt = $db->prepare($query);
        $db->exec($stmt);

        foreach ($_SESSION['cart'] as $pId => $items) {
            $pId = $items['productId'];
            $pStartDate = $items['pStartDate'];
            $pEndDate = $items['pEndDate'];
            $pAmount = $items['pAmount'];

            $query = "SELECT klantid FROM klant WHERE email = '$customerEmail'";
            $stmt = $db->prepare($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $klantId = $result;

            $query = "SELECT orderId FROM 'order' WHERE order_klantID = '$result'";
            $stmt = $db->prepare($query);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $orderId = $result;

            $query = "INSERT INTO orderregel (orderRegel_artikelID, orderRegel_orderID, bestelDatum, retourDatum, aantal)  VALUES ('$pId', $orderId, '$pStartDate', '$pEndDate', '$pAmount')";
            $stmt = $db->prepare($query);
            $db->exec($stmt);
        }
    }
}
?>


