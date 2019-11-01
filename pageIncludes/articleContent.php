<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/article.css">
</head>
<body>

<div id="page-wrapper">

<?php


$query = "SELECT * FROM product WHERE productID = ?";
$stmt = $db->prepare($query);
$stmt->execute(array($_GET['id']));
$products = $stmt->fetch();


        echo '<div class="productAfbeelding"><img src="'.$products['afbeelding'].'" alt="Productafbeelding"></div>';
        echo '<br>';

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

