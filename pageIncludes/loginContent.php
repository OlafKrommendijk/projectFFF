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
$error = " ";

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
            if (password_verify($password, $hash)){
                //Als het wachtwoord goed is wordt de session geupdate en wordt hij doorgestuurd naar de pagina voor medewerkers
                    $_SESSION["email"] = $result["email"];
                if ($email === 'medewerker1@gmail.com') {
                    $_SESSION["medewerkerID"] = 1;
                    $_SESSION["admin"] = 1;
                    $_SESSION["STATUS"] = 1;

                    header("Location: http://localhost/projectFFF/medewerkerPagina.php");
                    exit;

                    //Als de logingevens van een chauffeur zijn wordt hij ingelogd als chauffeur
                }elseif ($email === 'chauffeur1@gmail.com' || $email === 'chauffeur2@gmail.com' || $email === 'chauffeur3@gmail.com'){
                    $_SESSION["admin"] = 1;
                    $_SESSION["STATUS"] = 2;


                    header("Location: http://localhost/projectFFF/bestellingenRetour.php");
                    exit;
            }
            }else {
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