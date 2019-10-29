<?php
$query = "SELECT * FROM product";
$stmt = $db->prepare($query);
$stmt->execute(array());
$products = $stmt->fetchAll(PDO::FETCH_ASSOC);
$i = 0;
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/products.css">
</head>
<body>
<div id="page-wrapper">
    <h1> Onze Producten </h1>
    <div class="productGrid">

<?php
            foreach($products as $product){
                $i++;
                $afbeelding = $product['afbeelding'];
                $productId = $product['productID'];

                echo '<div class="productNumber' . $i .'"><div class="products">';

                echo '<div class="productAfbeelding"><img src="' . $afbeelding .  '" alt="Productafbeelding"></div>';
                echo '<br>';
                echo $product['naam'];
                echo '<br>';

                if ($product['prijs'] === NULL){
                    echo 'Prijs per dag: €' . $product['prijsDag']/100;
                    echo '<br>';
                    echo 'Prijs per week: €' . $product['prijsWeek']/100;
                    echo '<br>';
                } else{
                    echo 'Koopprijs: €' . $product['prijs']/100;
                    echo '<br><br><br>';
                }

                echo '<br>';
                echo '<form method="POST" action="./articlePage.php"><input type="hidden" name="productID" value="'.$productId.'" /><input class="button" type="submit" value="Koop of Huur nu" /></form>';
                echo '</div>';
                echo '</div>';

            }
            ?>
        </div>
    </div>
    </div>
</div>
</body>
</html>