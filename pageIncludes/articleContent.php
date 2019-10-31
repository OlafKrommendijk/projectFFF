<?php
$productID = $_POST['productID'];

$query = "SELECT * FROM product WHERE productID = '".$productID."'";
$stmt = $db->prepare($query);
$stmt->execute(array());
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/article.css">
    <script type="text/javascript" src="articleJS.js"></script>
</head>
<body>

<div id="page-wrapper">

<?php

function IsChecked($chkname,$value)
{
    if(!empty($_POST[$chkname]))
    {
        foreach($_POST[$chkname] as $chkval)
        {
            if($chkval == $value)
            {
                return true;
            }
        }
    }
    return false;
}

    foreach($products as $product){
        $afbeelding = $product['afbeelding'];

        echo '<div class="productAfbeelding"><img src="' . $afbeelding .  '" alt="Productafbeelding"></div>';
        echo '<br>';

        echo '<div class="descBox">';
        echo '<h1>'. $product['naam'] .'</h1>';

        echo '<p>'.$product['beschrijving'] .'</p>';
        echo '<br>';


        if ($product['prijs'] === NULL){
            echo '<br>';
            echo 'Prijs per dag: €' . $product['prijsDag']/100;
            echo '<br>';
            echo 'Prijs per week: €' . $product['prijsWeek']/100;
            echo '<br>';
        } else{
            echo 'Koopprijs: €' . $product['prijs']/100;
            echo '<br><br><br>';
        }

        if ($product['onderhoud'] === 1) {

            $onderhoud = "UPDATE product SET onderhoud='0' WHERE productID = '".$productID."'";
        } else{

            $onderhoud = "UPDATE product SET onderhoud='1' WHERE productID = '".$productID."'";
        }

        if (isset($_POST['inOnderhoud'])){
            $stmt = $db->prepare($onderhoud);
            $stmt->execute(array());
            $result = $stmt->fetch(PDO::FETCH_ASSOC);


            $message = "Product in of uit onderhoud gezet";
            echo "<script type='text/javascript'>alert('$message');</script>";
        }




        echo '</div>';
    }
?>




</div>
</body>
</html>

