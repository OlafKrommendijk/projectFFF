<?php
//Laad de benodigde bestanden in
include("DBconfig.php");
session_start();
//Kijkt of de gebruiker ingelogd is, zoja geeft hij header weer met andere links
if (isset($_SESSION["admin"]) && $_SESSION["STATUS"] === 1) {
    include_once('adminHeader.php');
}elseif (isset($_SESSION["admin"]) && $_SESSION["STATUS"] === 2){
    include_once('adminHeader.php');
}else{
    include_once('customerHeader.php');
}

