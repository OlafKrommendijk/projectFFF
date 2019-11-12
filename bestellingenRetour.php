<?php
//Laad de benodigde bestanden in

include_once('header.php');

//Kijktt of de bezoeker is ingelogd.
if (isset($_SESSION["admin"]) && $_SESSION["STATUS"] === 1 ){
    include_once('pageIncludes/bestellingenRetourContent.php');
}elseif ($_SESSION["STATUS"] === 2 ){
    include_once('pageIncludes/bestellingenRetourContent.php');
} else {
    echo "<script>alert('U moet ingelogd zijn om deze pagina te bekijken.'); location.href='index.php';</script>";
}

include_once('footer.php');