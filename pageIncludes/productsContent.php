<?php
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <link rel="stylesheet" href="./css/products.css">
</head>
<body>
<div id="page-wrapper">
    <div id="flexWrap">
        <h1> Onze Producten </h1>
            <?php
            $query = "SELECT * FROM product";
            $stmt = $db->prepare($query);
            $stmt->execute(array());
            $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($products as $product){
                echo '<div class="product"><div class="product-floatIn">';
                echo $product['afbeelding'];
                echo $product['naam'];
                echo $product['prijs'];
                echo $product['prijsDag'];
                echo $product['prijsWeek'];
                '</div></div>';
            }
            ?>
    </div>
</div>
</body>
</html>