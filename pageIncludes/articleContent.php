<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/article.css">
</head>
<body>

<div id="page-wrapper">

<?php
$pId = $_GET['id'];

$_SESSION['cart'][$pId] = Array();

$query = "SELECT * FROM product WHERE productID = ?";
$stmt = $db->prepare($query);
$stmt->execute(array($_GET['id']));
$products = $stmt->fetch();


        echo '<div class="productAfbeelding"><img src="'.$products['afbeelding'].'" alt="Productafbeelding">';
        echo '<br>';

        echo '<form method="post"><div class="reserveren">';

        if ($products['prijs'] === NULL) {
            echo '<input class="startDate" type="date" name="startDate"> Begin Datum  &nbsp';
            echo '<input class="endDate" type="date" name="endDate"> Eind Datum<br>';
            echo '<input class="amount" type="number" name="amount"> Aantal<br>';
            echo '<input type="submit" name="submit" id="submit" value="Reserveer!">';
        }else {
            echo '<input class="amount" type="number" name="amount"> Aantal<br>';
            echo '<input type="submit" name="submit" id="submit" value="Koop!">';
        }

        echo '</form></div></div>';

        if (isset($_POST["submit"])){

            if ($products['prijs'] === NULL) {
                $pStartDate = htmlspecialchars($_POST["startDate"]);
                $pEndDate = htmlspecialchars(htmlspecialchars($_POST["endDate"]));

                $pStartDateTime = new DateTime($pStartDate);
                $pEndDateTime = new DateTime ($pEndDate);

                $pAmount = htmlspecialchars($_POST["amount"]);

                $pName = $products['naam'];
                $pImage = $products['afbeelding'];
                $price = $products['prijs'];
                $priceDay = $products['prijsDag'];
                $priceWeek = $products['prijsWeek'];

                $dagen = 0;

                $interval = ($pStartDateTime->diff($pEndDateTime));
                $days = $interval->format('%d');
                $weeks = round($days / 7, 2);
                $whole = floor($weeks);
                $comma = round($weeks - $whole, 2);

                switch($comma){
                    case 0:
                        $dagen = 0;

                        $price = (($priceWeek * $whole) + ($priceDay * $dagen)) / 100;
                        $priceTotal = ((($priceWeek * $whole) + ($priceDay * $dagen)) / 100) * $pAmount;
                        break;
                    case 0.14:
                        $dagen = 1;

                        $price = (($priceWeek * $whole) + ($priceDay * $dagen)) / 100;
                        $priceTotal = ((($priceWeek * $whole) + ($priceDay * $dagen)) / 100) * $pAmount;
                        break;
                    case 0.29:
                        $dagen = 2;

                        $price = (($priceWeek * $whole) + ($priceDay * $dagen)) / 100;
                        $priceTotal = ((($priceWeek * $whole) + ($priceDay * $dagen)) / 100) * $pAmount;
                        break;
                    case 0.43:
                        $dagen = 3;

                        $price = (($priceWeek * $whole) + ($priceDay * $dagen)) / 100;
                        $priceTotal = ((($priceWeek * $whole) + ($priceDay * $dagen)) / 100) * $pAmount;
                        break;
                    case 0.57:
                        $dagen = 4;

                        $price = (($priceWeek * $whole) + ($priceDay * $dagen)) / 100;
                        $priceTotal = ((($priceWeek * $whole) + ($priceDay * $dagen)) / 100) * $pAmount;
                        break;
                    case 0.71:
                        $dagen = 5;

                        $price = (($priceWeek * $whole) + ($priceDay * $dagen)) / 100;
                        $priceTotal = ((($priceWeek * $whole) + ($priceDay * $dagen)) / 100) * $pAmount;
                        break;
                    case 0.86:
                        $dagen = 6;

                        $price = (($priceWeek * $whole) + ($priceDay * $dagen)) / 100;
                        $priceTotal = ((($priceWeek * $whole) + ($priceDay * $dagen)) / 100) * $pAmount;
                        break;
                }

                if(!$_POST["startDate"]|| !$_POST["endDate"] || !$_POST["amount"] || $_POST["amount"] === 0){
                    $message = 'U moet een datum en aantal invullen';
                    echo "<script type='text/javascript'>alert('$message');</script>";
                } else {
                    $message = 'Product gereserveerd';
                    echo "<script type='text/javascript'>alert('$message');</script>";
                    $_SESSION['cart'][$pId] = Array('pImage' => $pImage, 'pName' => $pName, 'pStartDate' => $pStartDate, 'pEndDate' => $pEndDate, 'price' => $price, 'priceTotal' => $priceTotal);
                }

            }else{
                $pAmount = htmlspecialchars($_POST["amount"]);

                $pName = $products['naam'];
                $pImage = $products['afbeelding'];
                $price = $products['prijs'] / 100;
                $priceDay = $products['prijsDag'];
                $priceWeek = $products['prijsWeek'];


                $priceTotal = ($price) * $pAmount /100;

                $message = 'Product gereserveerd';
                echo "<script type='text/javascript'>alert('$message');</script>";
                $_SESSION['cart'][$pId] = Array('pImage' => $pImage, 'pName' => $pName, 'pStartDate' => "Koopproduct", 'pEndDate' => " ", 'price' => $price, 'priceTotal' => $priceTotal);
            }
        }



        echo '<div class="descBox">';
        echo '<h1>'. $products['naam'] .'</h1>';

        echo '<p>'.$products['beschrijving'] .'</p>';
        echo '<br>';


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

        echo '<form method="POST"><div class="onderhoud">';
            if ($products["onderhoud"] == 0) {
                echo '<input type="checkbox" value="unchecked" name="unchecked" onchange="this.form.submit();"> In onderhoud';
            } else if ($products["onderhoud"] == 1) {
                echo '<input type="checkbox" value="checked" name="checked" onchange="this.form.submit()"><a style="color: red">In onderhoud</a>';
            }
        echo '</div></form>';

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

