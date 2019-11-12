<?php
//Maakt de dag van vandaag aan als variable
$dateNow = date('Y-m-d');

//query die alle orders van vandaag ophaalt
$query = "SELECT * FROM orders INNER JOIN orderregel ON orderRegel_orderID = ordersID INNER JOIN klant ON orders_klantID = klantID  WHERE retourDatum = '$dateNow' AND bezorgen = 0 OR bestelDatum = '$dateNow' AND bezorgen = 0;";

//prepared de query en voert hem uit
$stmt = $db->prepare($query);
$stmt->execute(array());
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>
<!--Zet de juiste gegevens in de lijst-->
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
    </tr>
    </thead>
    <?php
    foreach ($result as $id => $order) { ?>
        <tbody>
        <tr>
            <td><?php echo $order["ordersID"] ?></td>
            <td><?php echo strtoupper($order["naam"][0]) . ' ' .$order["tussenvoegsel"]. ' ' . ucfirst($order["achternaam"]) ?></td>
            <td> <?php echo $order["totaalprijs"] ?></td>
        </tr>
        </tbody>
    <?php } ?>
</table>
<script>
    //Als de pagina laad, voert de functie zichzelf uit. Hierna wordt je doorgestuurd na de pagina voor de lijsten
    window.onload = function () {
        tableToExcel('testTable', 'W3C Example Table', '<?php echo $dateNow ?>Medewerker.xls');
        location.href = "./lijsten.php"
    };
    //Via deze functie downloaden wij het excel bestand
    var tableToExcel = (function () {
        var uri = 'data:application/vnd.ms-excel;base64,',
            template = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40"><head><!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>{worksheet}</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]--></head><body><table>{table}</table></body></html>',
            base64 = function (s) {
                return window.btoa(unescape(encodeURIComponent(s)))
            }, format = function (s, c) {
                return s.replace(/{(\w+)}/g, function (m, p) {
                    return c[p];
                })
            }
        return function (table, name, filename) {
            if (!table.nodeType) table = document.getElementById(table)
            var ctx = {
                worksheet: name || 'Worksheet',
                table: table.innerHTML
            }
            document.getElementById("dlink").href = uri + base64(format(template, ctx));
            document.getElementById("dlink").download = filename;
            document.getElementById("dlink").click();
        }
    })()
</script>