<?php
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/shoppingcart.css">
</head>
<body>

<div class="page-wrapper">

    <div id="shoppingcartProducts">
        <?php
        if (isset($_SESSION['cart'] )) {
            foreach ($_SESSION['cart'] as $pId => $items) {
                echo '<div id="product">';
                echo '<div class="productAfbeelding"><img src="' . $items['pImage'] . '" alt="Productafbeelding"><br />';
                echo $items['pName'] . '<br />';
                echo $items['pStartDate'] . '<br />';
                echo $items['pEndDate'] . '<br />';
                if ($items['price'] == 0) {
                    echo '€ ' . $items['priceDay'] / 100 . '<br />';
                    echo '€ ' . $items['priceWeek'] / 100 . '<br />';
                } else {
                    echo '€ ' . $items['price'] / 100 . '<br />';
                }
                echo '</div>';
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
        <input class="shoppingcartInput" type="radio" name="bezorgen"> Bezorgkosten + €50,-<br><br>
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

}
?>


