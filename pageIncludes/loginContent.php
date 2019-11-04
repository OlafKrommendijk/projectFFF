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

<?php
//checked over op de submit knop is gedrukt.
if (isset($_POST["submit"])) {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    //probeert in de database de data te vinden die gelijk is met de email die is ingevuld.
    try {
        $sql = "SELECT * FROM medewerker WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($email));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //Controleert of het wachtwoord goed is.
        if ($result) {
            $hash = $result["wachtwoord"];

            //Als het wachtwoord goed is wordt de session geupdate en wordt hij doorgestuurd naar de pagina voor medewerkers
            if (password_verify($password, $hash)) {
                $_SESSION["medewerkerID"] = 1;
                $_SESSION["email"] = $result["email"];
                $_SESSION["admin"] = 1;
                $_SESSION["STATUS"] = 1;

                header("Location: http://localhost/projectFFF/medewerkerPagina.php");
                exit;

                //error message als de inloggegevens verkeerd zijn ingevuld.
            } else {
                $error .= "Inloggegevens ongeldig. <br>";
            }
        } else {
            $error .= "Inloggegevens ongeldig. <br>";
        }
    } catch (PDOException $e) {
        echo $e->getMessage();
    }
}
?>