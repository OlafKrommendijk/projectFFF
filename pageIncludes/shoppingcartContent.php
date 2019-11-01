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
        if (!$_SESSION['cart'] ) {
            echo 'Er zit geen product in uw winkelwagen';
        }else{
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
        }
    ?>
    </div>

    <form id="cartForm" method="POST">
        <input class="shoppingcartInput" type="email" name="email" placeholder="Email"> Email<br>
        <input class="shoppingcartInput" type="text" name="naam" placeholder="Naam"> Naam<br>
        <input class="shoppingcartInput" type="text" name="tussenvoegsel" placeholder="Tussenvoegsel"> Tussenvoegsel<br>
        <input class="shoppingcartInput" type="text" name="achternaam" placeholder="Achternaam"> Achternaam<br>
        <input class="shoppingcartInput" type="text" name="straatnaam" placeholder="Straatnaam"> Straatnaam<br>
        <input class="shoppingcartInput" type="number" name="huisnummer" placeholder="Huisnummer"> Huisnummer<br>
        <input class="shoppingcartInput" type="text" name="postcode" placeholder="Postcode"> Postcode<br>
        <input class="shoppingcartInput" type="text" name="woonplaats" placeholder="Wooonplaats"> Woonplaats<br>
        <input class="shoppingcartInput" type="radio" name="bezorgen"> Bezorgkosten + €50,-<br><br>
        <input type="submit" value="Koop/Reserveer">
    </form>
</div>
</html>


