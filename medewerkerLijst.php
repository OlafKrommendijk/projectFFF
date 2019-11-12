<?php
//Laad de benodigde bestanden in

include_once('header.php');

//Kijktt of de bezoeker is ingelogd.
if (isset($_SESSION["admin"]) && $_SESSION["STATUS"] === 1){
    include_once('lijst/medewerker.php');
    include_once('footer.php');
} else {
    echo "<script>alert('U moet ingelogd zijn om deze pagina te bekijken.'); location.href='index.php';</script>";
}
