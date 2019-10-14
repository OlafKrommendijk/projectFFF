<?php
include("DBconfig.php");
session_start();
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="css/header.css">
</head>
<body>
<header class="login-header">
    <div class="loginContainer">
        <nav class="main-nav">
            <ul class="main-nav-list">
                <li>
                    <a class="loginButton" href="pages/login.php">Inloggen</a>
                </li>
            </ul>
        </nav>
        <h1 class="mh-logo">
            <img src="pictures/logo.jpg" alt="Logo van FFF">
        </h1>

    </div>
</header>
<header class="main-header">
    <div class="container">
        <nav class="main-nav">
            <ul class="main-nav-list">
                <li>
                    <a href="#">Home</a>
                </li>
                <li>
                    <a href="#">Producten</a>
                </li>
                <li>
                    <a href="#">Winkelmand</a>
                </li>
                <li>
                    <a href="#">Contact</a>
                </li>
            </ul>
        </nav>
    </div>
</header>
