<?php
// Turn off all error reporting
error_reporting(0);
error_reporting( error_reporting() & ~E_NOTICE )
?>


<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/article.css">
</head>
<body>

<div id="page-wrapper">

<?php
//met get krijgt hij het productID
$pId = $_GET['id'];

//selecteert het product dat het juiste id heeft
$query = "SELECT * FROM product WHERE productID = ?";
$stmt = $db->prepare($query);
$stmt->execute(array($_GET['id']));
$products = $stmt->fetch();

        //laat informatie over het product zien
        echo '<div class="productAfbeelding"><img src="'.$products['afbeelding'].'" alt="Productafbeelding">';
        echo '<br>';

        echo '<form method="post"><div class="reserveren">';

        //Kijkt of het product in onderhoud zit
        if ($products['onderhoud'] == 1){
            echo '<p> Product zit in onderhoud. </p>';
        }
        //als het een huurproduct is kan de klant een datum selecteren
        elseif ($products['prijs'] === NULL) {
            echo '<input class="startDate" type="date" name="startDate"> Begin Datum  &nbsp';
            echo '<input class="endDate" type="date" name="endDate"> Eind Datum<br>';
            echo '<input class="amount" type="number" name="amount"> Aantal<br>';
            echo '<input type="submit" name="submit" id="submit" value="Reserveer!">';
        }else {
            echo '<input class="startDate" type="date" name="startDate"> Ophaal/bezorgdatum<br>';
            echo '<input class="amount" type="number" name="amount"> Aantal<br>';
            echo '<input type="submit" name="submit" id="submit" value="Koop!">';
        }

        echo '</form></div></div>';

        echo '<div class="descBox">';
        echo '<h1>'. $products['naam'] .'</h1>';

        echo '<p>'.$products['beschrijving'] .'</p>';
        echo '<br>';

        //laat de huurprijs zijn voor een huurproduct, anders de koopprijs
        if ($products['prijs'] === NULL){
            echo '<br>';
            echo 'Prijs per dag: €' . $products['prijsDag']/100;
            echo '<br>';
            echo 'Prijs per week: €' . $products['prijsWeek']/100;
            echo '<br>';
        } else{
            echo 'Koopprijs: €' . $products['prijs']/100;
            echo '<br><br><br>';
        }

        //Laat de knop zien voor onderhoud, als een product in onderhoud is wordt de tekst rood
        echo '<form method="POST"><div class="onderhoud">';
        if ($products["onderhoud"] == 0 && $_SESSION["admin"] && $_SESSION["STATUS"] === 1) {
            echo '<input type="checkbox" value="unchecked" name="unchecked" onchange="this.form.submit();"> In onderhoud';
        } else if ($products["onderhoud"] == 1 && $_SESSION["admin"] && $_SESSION["STATUS"] === 1) {
            echo '<input type="checkbox" value="checked" name="checked" onchange="this.form.submit()"><a style="color: red">In onderhoud</a>';
        }
        else{
            echo ' ';
        }
        echo '</div></form>';

        //als er op de reserveer of koop knop wordt gedrukt wordt er eerst gekeken of alle velden juist zijn ingevuld en of het een koop of huur product is
        if (isset($_POST["submit"])) {
            if ($products['prijs'] === NULL) {
                if (!$_POST["startDate"] || !$_POST["endDate"] || !$_POST["amount"] || $_POST["amount"] === 0 || $_POST["amount"] < 1) {
                    $message = 'U moet een datum en aantal invullen';
                    echo "<script type='text/javascript'>alert('$message');</script>";

                    exit();
                } else {
                    //maakt de juiste datum objecten aan
                    $pStartDate = $_POST["startDate"];
                    $pEndDate = $_POST["endDate"];
                    $dateNow = new DateTime();
                    $pStartDateTime = new DateTime($pStartDate);
                    $pEndDateTime = new DateTime ($pEndDate);

                    $now = date('Y-m-d');
                    $start = date($_POST["startDate"]);
                    $end = date($_POST["endDate"]);

                }
                //controleert of de eind datum voor de startdatum is
                if($pEndDate < $pStartDate){
                    $message = 'De einddatum moet zich bevinden voor de startdatum';
                    echo "<script type='text/javascript'>alert('$message');</script>";
                //controleert de startdatum na vandaag is
                }elseif($start < $now){
                    $message = 'De startdatum moet na vandaag zijn ';
                    echo "<script type='text/javascript'>alert('$message');</script>";

                }else {
                    //maakt de cart session aan
                    $_SESSION['cart'][$pId] = Array();

                    $pAmount = htmlspecialchars($_POST["amount"]);
                    $pName = $products['naam'];
                    $pImage = $products['afbeelding'];
                    $price = $products['prijs'];
                    $priceDay = $products['prijsDag'];
                    $priceWeek = $products['prijsWeek'];
                    $category = $products['artikel_categorieID'];

                    $dagen = 0;

                    //rekent het aantal weken en dagen uit
                    $interval = date_diff($pStartDateTime, $pEndDateTime);
                    $days = $interval->format("%a");
                    $weeks = round($days / 7, 2);
                    $week = floor($weeks);
                    $dagenComma = round($weeks - $week, 2);

                    //rekent de juiste prijs uit
                    switch ($dagenComma) {
                        case 0:
                            $dagen = 0;

                            $price = (($priceWeek * $week) + ($priceDay * $dagen)) / 100;
                            $priceTotal = ((($priceWeek * $week) + ($priceDay * $dagen)) / 100) * $pAmount;
                            break;
                        case 0.14:
                            $dagen = 1;

                            $price = (($priceWeek * $week) + ($priceDay * $dagen)) / 100;
                            $priceTotal = ((($priceWeek * $week) + ($priceDay * $dagen)) / 100) * $pAmount;
                            break;
                        case 0.29:
                            $dagen = 2;

                            $price = (($priceWeek * $week) + ($priceDay * $dagen)) / 100;
                            $priceTotal = ((($priceWeek * $week) + ($priceDay * $dagen)) / 100) * $pAmount;
                            break;
                        case 0.43:
                            $dagen = 3;

                            $price = (($priceWeek * $week) + ($priceDay * $dagen)) / 100;
                            $priceTotal = ((($priceWeek * $week) + ($priceDay * $dagen)) / 100) * $pAmount;
                            break;
                        case 0.57:
                            $dagen = 4;

                            $price = (($priceWeek * $week) + ($priceDay * $dagen)) / 100;
                            $priceTotal = ((($priceWeek * $week) + ($priceDay * $dagen)) / 100) * $pAmount;
                            break;
                        case 0.71:
                            $dagen = 5;

                            $price = (($priceWeek * $week) + ($priceDay * $dagen)) / 100;
                            $priceTotal = ((($priceWeek * $week) + ($priceDay * $dagen)) / 100) * $pAmount;
                            break;
                        case 0.86:
                            $dagen = 6;

                            $price = (($priceWeek * $week) + ($priceDay * $dagen)) / 100;
                            $priceTotal = ((($priceWeek * $week) + ($priceDay * $dagen)) / 100) * $pAmount;
                            break;
                    }
                    //stopt het product in de cart session
                    $message = 'Product gereserveerd';
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    $category = $products['artikel_categorieID'];

                    $_SESSION['cart'][$pId] = Array('productId' => $pId, 'pImage' => $pImage, 'pName' => $pName, 'dagen' => $dagen, 'week' => $week, 'pStartDate' => $pStartDate, 'pEndDate' => $pEndDate, 'price' => $price, 'priceWeek' => $priceWeek, 'priceDay' => $priceDay, 'priceTotal' => $priceTotal, 'pAmount' => $pAmount, 'artikel_categorieID' => $category);
                }
                //controleert of het aantal is ingevuld
            } elseif ($_POST["amount"] === 0 || $_POST["amount"] < 1) {
                    $message = 'U moet een aantal invullen';
                    echo "<script type='text/javascript'>alert('$message');</script>";

                    exit();
            }else {
                //zet het koopproduct in de winkelmand
                $pAmount = htmlspecialchars($_POST["amount"]);

                $pName = $products['naam'];
                $pImage = $products['afbeelding'];
                $price = $products['prijs'] / 100;
                $priceDay = $products['prijsDag'];
                $priceWeek = $products['prijsWeek'];
                $category = $products['artikel_categorieID'];
                $priceTotal = ($price) * $pAmount;
                $pStartDate = $_POST["startDate"];

                $message = 'Product gereserveerd';
                echo "<script type='text/javascript'>alert('$message');</script>";
                $_SESSION['cart'][$pId] = Array('productId' => $pId,'pImage' => $pImage, 'pName' => $pName, 'pStartDate' => "$pStartDate", 'pEndDate' => "Koopproduct", 'price' => $price, 'priceTotal' => $priceTotal, 'pAmount' => $pAmount, 'artikel_categorieID' => $category);
                }
        }


        //zet het product in of uit onderhoud in de database
        if (isset($_POST["unchecked"])) {
            $query = "UPDATE product SET onderhoud='1' WHERE productID='".$products['productID']."'";
            $db->exec($query);
            header('Refresh:0');
            exit;

        } else if (isset($_POST["checked"])) {
            $query = "UPDATE product SET onderhoud='0' WHERE productID='".$products['productID']."'";
            $db->exec($query);
            header('Refresh:0');
            exit;
        }
        echo '</div>';
?>


</div>
</body>
</html>

