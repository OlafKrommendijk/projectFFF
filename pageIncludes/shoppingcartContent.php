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
                echo '<div class="productAfbeelding"><img src="' . $items['pImage'] . '" alt="Productafbeelding"></div><pre class="tab">' . ' ' . $items['pName'] .  '        ' . $items['pStartDate'] . '     ' . $items['pEndDate'] . '     ';
                if ($items['price'] == 0) {
                    echo '€' . $items['priceDay'] / 100 . ' ' . '€' . $items['priceWeek'] / 100;
                } else {
                    echo '€' . $items['price'] / 100;
                }
                echo '<form id="verwijderButton" method="POST"><input type="submit" name="verwijder" id="verwijder" value="verwijder"></form></pre></div>';
            }
        }else{
            echo 'Er zit geen product in uw winkelwagen';
        }
    ?>
    </div>

    <form id="cartForm" method="POST">
        <input class="shoppingcartInput" type="email" name="email" placeholder="Email"> Email<br>
        <input class="shoppingcartInput" type="text" name="firstname" placeholder="Naam"> Naam<br>
        <input class="shoppingcartInput" type="text" name="tussenvoegsel" placeholder="Tussenvoegsel"> Tussenvoegsel<br>
        <input class="shoppingcartInput" type="text" name="lastname" placeholder="Achternaam"> Achternaam<br>
        <input class="shoppingcartInput" type="text" name="street" placeholder="Straatnaam"> Straatnaam<br>
        <input class="shoppingcartInput" type="number" name="number" placeholder="Huisnummer"> Huisnummer<br>
        <input class="shoppingcartInput" type="text" name="postal" placeholder="Postcode"> Postcode<br>
        <input class="shoppingcartInput" type="text" name="city" placeholder="Stad"> Stad<br>
        <input class="shoppingcartInput" type="radio" name="bezorgen"> Bezorgkosten + €50,-
        <input type="submit" value="Koop/Reserveer">
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
    

    $customerDeliver = $_POST['bezorgen'];



    if (filter_var($customerEmail, FILTER_VALIDATE_EMAIL)) {
        $checkedEmail = filter_var($customerEmail, FILTER_VALIDATE_EMAIL);
        $sql = "SELECT email FROM gebruiker WHERE email = :email";
        $stmt = $db->prepare($sql);
        $stmt->execute(['email' => $customerEmail]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $response = null;
        $_SESSION["email"] = $customerEmail;

        if ($result > 0) {
            echo "<script>location.href='../index.php';
            setTimeout([alert('Het ingevulde emailadres is al in gebruikt')] ,3000);
            </script>";
        } else if (isset($_POST["submit"])) {
            $query = "INSERT INTO klant (naam, tussenvoegsel, achternaam, email)  VALUES ('$customerFirstname', '$customerBetween', '$customerLastname', '$customerEmail')";
            $stmt = $db->prepare($query);
            $db->exec($stmt);

            $query = "INSERT INTO address (straat, huisnummer, postcode, woonplaats)  VALUES ('$customerStreet', '$customerNumber', '$customerPostal', '$customerCity')";
            $stmt = $db->prepare($query);
            $db->exec($stmt);

            $query = "INSERT INTO orderregel (bestelDatum, aantal)  VALUES ('$orderTime', '$customerNumber', '$customerPostal', '$customerCity')";
            $stmt = $db->prepare($query);
            $db->exec($stmt);
        }


    }

}
?>


