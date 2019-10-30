<?php
include("DBconfig.php");
session_start();

if (isset($_SESSION["admin"]) && $_SESSION["STATUS"] === 1) {
    include_once('adminHeader.php');
}else{
    include_once('customerHeader.php');
}
?>
