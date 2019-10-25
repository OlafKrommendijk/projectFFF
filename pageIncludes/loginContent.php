<?php
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/login.css">
</head>
<body>

<div id="page-wrapper">
    <form name="inloggen" method="POST" enctype="multipart/form-data" action=" ">
        <input required type="email" name="email" placeholder="bij@voorbeeld.com"  />
        <input required type="password" name="password" placeholder="Wachtwoord" />
        <input type="hidden" name="submit" value="true" />
        <input type="submit" id="submit" value=" Inloggen " />
    </form>
</div>
</body>
</html>