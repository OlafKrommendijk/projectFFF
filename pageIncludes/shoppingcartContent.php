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
                echo '<div class="productAfbeelding"><img src="' . $items['pImage'] . '" alt="Productafbeelding"></div><pre class="tab">' . '' . $items['pName'] .  '    ' . $items['pStartDate'] . '    ' . $items['pEndDate'] . '   €' . $items['price'] . '     €' .$items['priceTotal']. '     </pre>';
                echo '<form method="POST"><input type="number" onchange="this.form.submit()" name="nieuwAantal" value="'.$items['pAmount'].'"><input type="hidden" name="submitAantal" value="'.$pId.'"></form>';
                echo '<form class="verwijder" method="POST"><input class="hidden" type="hidden" name="productId" value="'.$items['productId'].'"><input type="submit" name="deleteProduct" value="Verwijder"></form>';

                echo '</div>';
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
        <input class="shoppingcartInput" type="checkbox" name="bezorgen" id="bezorg" value=1> Bezorgkosten + €50,-
        <input type="submit" id="submit" name="submit" value="Koop/Reserveer">
    </form>
</div>
</html>

<?php

if (isset($_POST['deleteProduct'])) {
    $pId = htmlspecialchars($_POST['productId']);

    unset($_SESSION['cart'][$pId]);
    echo "<script>alert('Het product is verwijderd uit uw winkelwagen');</script>";
    header('Refresh:0');
}

if (isset($_POST["submitAantal"])) {
    $id = $_POST["submitAantal"];
    $nieuwAantal = $_POST["nieuwAantal"];

    $pCategory = $_SESSION['cart'][$id]['artikel_categorieID'];
    $price = $_SESSION['cart'][$id]['price'];

    $week = $_SESSION['cart'][$id]['week'];
    $dagen = $_SESSION['cart'][$id]['dagen'];
    $priceWeek = $_SESSION['cart'][$id]['priceWeek'];
    $priceDay = $_SESSION['cart'][$id]['priceDay'];
    $priceTotal = $_SESSION['cart'][$id]['priceTotal'];

    if ($nieuwAantal <= 0) {
        echo '<script language="javascript">';
        echo 'alert("Voer een ander aantal in")';
        echo '</script>';
    } else {
        //    Zet nieuwe aantal in array
        $_SESSION['cart'][$id]['pAmount'] = $nieuwAantal;

        if ($pCategory == 1){
            $newPriceTotal = $price * $nieuwAantal;
            $_SESSION['cart'][$id]['priceTotal'] = $newPriceTotal;
            //    Herladen pagina
            echo "<script>window.location = 'shoppingCart.php';</script>";
            exit;
        }else {
            $newPriceTotal = ((($priceWeek * $week) + ($priceDay * $dagen)) / 100) * $nieuwAantal;
            $_SESSION['cart'][$id]['priceTotal'] = $newPriceTotal;
            //    Herladen pagina
            echo "<script>window.location = 'shoppingCart.php';</script>";
            exit;
        }
    }
}

if (isset($_POST['submit'])) {
    $customerEmail = htmlspecialchars($_POST['email']);
    $customerFirstname = htmlspecialchars($_POST['firstname']);
    $customerBetween = htmlspecialchars($_POST['tussenvoegsel']);
    $customerLastname = htmlspecialchars($_POST['lastname']);
    $customerStreet = htmlspecialchars($_POST['street']);
    $customerNumber = htmlspecialchars($_POST['number']);
    $postal = htmlspecialchars($_POST['postal']);
    $customerPostal = substr(str_replace(' ', '', strtoupper($postal)), 0, 6);
    $customerCity = htmlspecialchars($_POST['city']);

    if(!preg_match('/\d\d\d\d[A-Z]{2}/', $customerPostal)){
        $message = 'Voer uw postcode juist in';
        echo "<script type='text/javascript'>alert('$message');</script>";

    }else if(empty($customerEmail) || empty($customerFirstname) || empty($customerLastname) || empty($customerStreet) || empty($customerNumber) || empty($customerPostal) || empty($customerCity)){
        $message = 'Voer alle velden in';
        echo "<script type='text/javascript'>alert('$message');</script>";
    }else if (filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
            $checkedEmail = filter_var($customerEmail, FILTER_VALIDATE_EMAIL);
            $sql = "SELECT email FROM klant WHERE email = :email";
            $stmt = $db->prepare($sql);
            $stmt->execute(['email' => $checkedEmail]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result > 0) {
//          Code voor als het email al in gebruik is
                $query = "SELECT klantID FROM klant WHERE email = :email";
                $stmt = $db->prepare($query);
                $stmt->execute(['email' => $customerEmail]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $klantId = implode($result);

                if($query){
                    $query = "SELECT straat, huisnummer, postcode, woonplaats FROM address WHERE address_klantID = '$klantId'";
                    $stmt = $db->prepare($query);
                    $stmt->execute(['email' => $customerEmail]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);

                    if($result['straat'] !== $customerStreet || $result['huisnummer'] !== $customerNumber || $result['woonplaats'] !== $customerCity || $result['postcode'] !== $customerPostal){
                        $query = "INSERT INTO address (address_klantID, straat, huisnummer, postcode, woonplaats)  VALUES ('$klantId', '$customerStreet', '$customerNumber', '$customerPostal', '$customerCity')";
                        $db->exec($query);
                    }
                }


            }else {
                $query = "INSERT INTO klant (naam, tussenvoegsel, achternaam, email)  VALUES ('$customerFirstname', '$customerBetween', '$customerLastname', '$customerEmail')";
                $db->exec($query);

                if ($query) {
                    $sql = "SELECT klantID FROM klant WHERE email = :email";
                    $stmt = $db->prepare($sql);
                    $stmt->execute(['email' => $customerEmail]);
                    $result = $stmt->fetch(PDO::FETCH_ASSOC);
                    $klantId = implode($result);

                    $query = "INSERT INTO address (address_klantID, straat, huisnummer, postcode, woonplaats)  VALUES ('$klantId', '$customerStreet', '$customerNumber', '$customerPostal', '$customerCity')";
                    $db->exec($query);
                }
            }


            $query = "SELECT addressID FROM address WHERE address_klantID = '$klantId' AND straat  = '$customerStreet' AND huisnummer = '$customerNumber' AND postcode = '$customerPostal' AND woonplaats = '$customerCity'";
            $stmt = $db->prepare($query);
            $stmt->execute([]);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $addressID = $result['addressID'];

            if ($query) {
                if(isset($_POST['bezorgen'])){
                    $customerDeliver = $_POST['bezorgen'];
                    $totaalprijs = 50;
                }else{
                    $customerDeliver = 0;
                    $totaalprijs = 0;
                }
                $query = "INSERT INTO orders (orders_klantID, orders_addressID, bezorgen)  VALUES ('$klantId', '$addressID', '$customerDeliver')";
                $db->exec($query);
            }

            foreach ($_SESSION['cart'] as $pId => $items) {
                $pId = $items['productId'];
                $pAmount = $items['pAmount'];
                $pCategory = $items['artikel_categorieID'];
                $totaalprijs = $totaalprijs + $items['priceTotal'];

                $query = "SELECT ordersID FROM orders WHERE orders_klantID = '$klantId' AND orders_addressID = '$addressID'";
                $stmt = $db->prepare($query);
                $stmt->execute([]);
                $result = $stmt->fetch(PDO::FETCH_ASSOC);
                $orderId = implode($result);

                //Kijkt of het product een koop of huur product is
                if ($pCategory == 1) {
                    $query = "INSERT INTO orderregel (orderRegel_artikelID, orderRegel_orderID, aantal)  VALUES ('$pId', '$orderId', '$pAmount')";
                    $stmt = $db->prepare($query);
                    $stmt->execute([]);
                } else {
                    $pStartDate = $items['pStartDate'];
                    $pEndDate = $items['pEndDate'];

                    $query = "INSERT INTO orderregel (orderRegel_artikelID, orderRegel_orderID, bestelDatum, retourDatum, aantal)  VALUES ('$pId', '$orderId', '$pStartDate', '$pEndDate', '$pAmount')";
                    $stmt = $db->prepare($query);
                    $stmt->execute([]);
                }
            }

            $query = "UPDATE orders SET totaalprijs = '$totaalprijs' WHERE ordersID = '$orderId'";
            $stmt = $db->prepare($query);
            $stmt->execute([]);

            $message = "Winkelwagen is gereserveerd!";
            echo "<script type='text/javascript'>alert('$message');</script>";

            unset($_SESSION['cart']);
            header('Refresh:0');
            exit;
    }else{
        $message = "Voer uw winkelwagen juist in";
        echo "<script type='text/javascript'>alert('$message');</script>";
    }
}
?>


