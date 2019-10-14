<?php
$error = "";

//checked over op de submit knop is gedrukt.
if (isset($_POST["submit"])) {
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);

    //probeert in de database de data te vinden die gelijk is met de email die is ingevuld.
    try {
        $sql = "SELECT * FROM admin WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute(array($email));
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        //Controleert of het wachtwoord goed is.
        if ($result) {
            $hash = $result["wachtwoord"];

            //Als het wachtwoord goed is wordt de session geupdate en wordt hij doorgestuurd naar de lijsten pagina.
            if (password_verify($password, $hash)) {
                $_SESSION["ID"] = 1;
                $_SESSION["EMAIL"] = $result["email"];
                $_SESSION["STATUS"] = 1;
                header("Location: http://localhost/projectFFF/pageIncludes/lijsten.php");
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
echo "<div id='meldingen'>" . $error . "</div>";