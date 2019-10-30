<?php
include_once('header.php');

if (isset($_SESSION["admin"]) && $_SESSION["STATUS"] === 1){
    include_once('pageIncludes/medewerkerPaginaContent.php');
    include_once('footer.php');
} else {
    echo "<script>alert('U moet ingelogd zijn om deze pagina te bekijken.'); location.href='index.php';</script>";
}

?>