<?php
//Laad de benodigde bestanden in

include('header.php');
//maakt de session kapot.
session_destroy();
header("Location: http://localhost/projectFFF/index.php");
exit;
