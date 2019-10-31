<?php
?>

<!--Pagina waar een bezoeker zich kan registreren-->

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/shoppingcart.css">
</head>
<body>

<div class="page-wrapper">
    <div id="shoppingcartProducts">

    </div>
    <form id="cartForm" method="POST">
        <input class="shoppingcartInput" type="text" name="naam" placeholder="Naam"> Naam<br>
        <input class="shoppingcartInput" type="text" name="tussenvoegsel" placeholder="Tussenvoegsel"> Tussenvoegsel<br>
        <input class="shoppingcartInput" type="text" name="achternaam" placeholder="Achternaam"> Achternaam<br>
        <input class="shoppingcartInput" type="email" name="email" placeholder="Email"> Email<br>
        <input class="shoppingcartInput" type="text" name="straatnaam" placeholder="Straatnaam"> Straatnaam<br>
        <input class="shoppingcartInput" type="number" name="huisnummer" placeholder="Huisnummer"> Huisnummer<br>
        <input class="shoppingcartInput" type="text" name="postcode" placeholder="Postcode"> Postcode<br>
        <input class="shoppingcartInput" type="text" name="woonplaats" placeholder="Wooonplaats"> Woonplaats<br>
        <input class="shoppingcartInput" type="radio" name="bezorgen"> Bezorgkosten + €50,-<br><br>
        <input type="submit" value="Koop/Reserveer">
    </form>
</div>
</html>

