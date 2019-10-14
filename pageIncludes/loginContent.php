<?php
include('../header.php');
?>
    <html>
    <head>
        <link rel="stylesheet" href="../css/login.css">
        <link rel="stylesheet" href="../css/header.css">
        <link rel="stylesheet" href="../css/footer.css">
    </head>

    <body>
    <div id="page-wrapper">
        <h2>Inloggen</h2>
        <form name="inloggen" method="POST" enctype="multipart/form-data" action=" ">
            <input required type="email" name="email" placeholder="bij@voorbeeld.com"  />
            <input required type="password" name="password" placeholder="Wachtwoord" />
            <input type="hidden" name="submit" value="true" />
            <input type="submit" id="submit" value=" Inloggen " />
        </form>
    </div>
    </body>
    </html>

<?php
include_once("../footer.php");
?>