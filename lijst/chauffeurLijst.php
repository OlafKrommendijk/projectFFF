<?php
$dateNow = date('Y-m-d');
$query = "SELECT * FROM orders INNER JOIN orderregel ON orderRegel_orderID = ordersID INNER JOIN klant ON orders_klantID = klantID INNER JOIN address ON orders_addressID = addressID WHERE retourDatum = '$dateNow' AND bezorgen = 1 OR bestelDatum = '$dateNow' AND bezorgen = 1 GROUP BY postcode ASC;";
$stmt = $db->prepare($query);
$stmt->execute(array());
$check = $stmt->fetchAll(PDO::FETCH_ASSOC);
$result = array_chunk($check, ceil(count($check) / 3));

if ($_SESSION["email"] === 'chauffeur1@gmail.com'){
    $result = $result[0];
}elseif ($_SESSION["email"] === 'chauffeur2@gmail.com'){
    $result = $result[1];
}elseif ($_SESSION["email"] === 'chauffeur3@gmail.com') {
    $result = $result[2];
}
?>
<a id="dlink" style="display:none;"></a>
<input type="button" onclick="tableToExcel('testTable', 'W3C Example Table', '<?php echo $dateNow ?>Medewerker.xls')"
       value="Export to Excel">

<table id="testTable" summary="Code page support in different versions of MS Windows." rules="groups" frame="hsides"
       border="2">

    <colgroup align="center"></colgroup>
    <colgroup align="left"></colgroup>
    <colgroup span="2" align="center"></colgroup>
    <colgroup span="3" align="center"></colgroup>
    <thead valign="top">
    <tr>
        <th>FactuurNummer</th>
        <th>Naam van klant</th>
        <th>Totaalbedrag</th>
        <th>Postcode</th>
    </tr>
    </thead>
    <?php
    foreach ($result as $id => $order) { ?>
        <tbody>
        <tr>
            <td><?php echo $order["ordersID"] ?></td>
            <td><?php echo strtoupper($order["naam"][0]) . '.' . ucfirst($order["achternaam"]) ?></td>
            <td> <?php echo $order["totaalprijs"] ?></td>
            <td> <?php echo $order["postcode"] ?></td>
        </tr>
        </tbody>
    <?php } ?>
</table>
<script>
