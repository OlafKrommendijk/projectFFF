<?php
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
        <div class="products">
            <?php
            $query = "SELECT * FROM product";
            $stmt = $db->prepare($query);
            $stmt->execute(array());
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);


            $i = 0;

            foreach($products as $product){
                $i++;
                $afbeelding = $product['afbeelding'];

                echo '<div class="productNumber' . $i .'">';
                echo '<img src="' . $afbeelding .  '" width="10%" alt="Productafbeelding">';
                echo '<br>';
                echo $product['naam'];
                echo '<br>';

                if ($product['prijs'] === NULL){
                    echo 'Prijs per dag: €' . $product['prijsDag']/100;
                    echo '<br>';
                    echo 'Prijs per week: €' . $product['prijsWeek']/100;
                } else{
                    echo 'Koopprijs: €' . $product['prijs']/100;
                }
                echo '</div>';
            }
            ?>
        </div>
    </div>
    </div>
</div>
</body>
</html>