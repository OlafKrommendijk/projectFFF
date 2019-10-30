<!--Zo kan de admin uitloggen-->

<?php
include('header.php');
//maakt de session kapot.
session_destroy();
header("Location: http://localhost/projectFFF/index.php");
exit;

?>