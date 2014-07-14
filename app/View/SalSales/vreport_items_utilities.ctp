<span style="font-size: 25px; font-weight: bold">IMEXPORT</span><span style="font-weight: bold">SRL</span>
<hr style="height: 2px; color: #000; background-color: #000;">
<div style="font-size: 20px; font-weight: bold; text-align:center; text-decoration: underline;">UTILIDADES DE PRODUCTOS</div>
<br>
<?php
$currencyAbbr = '(Bs)';
if ($data["currency"] == "DOLARES") {
    $currencyAbbr = '($us)';
}
?>

<table class="report-table" border="0" style="border-collapse:collapse; width:100%;">
    <thead>
        <tr style="text-align:center">
            <th style="width:33%">Fecha Inicio:</th>
            <th style="width:33%">Fecha Fin:</th>
            <th style="width:33%">Tipo de Cambio:</th>
        </tr>
    </thead>
    <tbody>
        <tr style="text-align:center">
            <td><?php echo $data['startDate']; ?></td>
            <td><?php echo $data['finishDate']; ?></td>
            <td><?php echo $data['currency']; ?></td>
        </tr>
    </tbody>
</table>

<table class="report-table" border="1" style="border-collapse:collapse; width:100%;">
    <tr><td style="width:10%; font-weight: bold;">Cliente:</td><td><?php echo $data['customerName']; ?></td></tr>
    <tr><td style="width:10%; font-weight: bold;">Vendedor:</td><td><?php echo $data['salesmanName']; ?></td></tr>
</table>

<hr style="height: 1px; color: #444; background-color: #444;">
<table class="report-table" border="1" style="border-collapse:collapse; width:100%;">
    <thead>
        <tr>
            <th>#</th>
            <th>Codigo</th>
            <th>Nombre</th>
            <th>Cantidad (Unidad)</th>
            <th>Venta <?php echo $currencyAbbr; ?></th>
            <th>Costo CIF <?php echo $currencyAbbr; ?></th>
            <th>Utilidad <?php echo $currencyAbbr; ?></th>
            <th>Porcentaje (%)</th>
        </tr>
    </thead>
    <?php $counter = 1; ?>
    <?php foreach ($dataDetails as $dataDetail) { ?>
        <tr>
            <td style="text-align: center;"><?php echo $counter; ?></td>
            <td style="padding-left: 10px;"><?php echo $dataDetail["code"]; ?></td>
            <td style="padding-left: 10px;"><?php echo $dataDetail["name"]; ?></td>
            <td style="padding-left: 10px;"><?php echo $dataDetail["quantity"]; ?></td>
            <td style="text-align: center;"><?php echo number_format($dataDetail["sale"], 2); ?></td>
            <td style="text-align: center;"><?php echo number_format($dataDetail["cif"], 2); ?></td>
            <td style="text-align: center;"><?php echo number_format($dataDetail["utility"], 2); ?></td>
            <td style="text-align: center;"><?php echo number_format($dataDetail["margin"], 2); ?></td>
        </tr>
        <?php
        $counter++;
    }
    ?>
    <tr>
        <td style="text-align:right;font-weight:bold;padding-right:5px;" colspan="3">TOTAL:</td>
        <td style="padding-left: 10px;font-weight:bold;"><?php echo $arrTotal["quantity"]; ?></td>
        <td style="text-align: center;font-weight:bold;"><?php echo number_format($arrTotal["sale"], 2); ?></td>
        <td style="text-align: center;font-weight:bold;"><?php echo number_format($arrTotal["cif"], 2); ?></td>
        <td style="text-align: center;font-weight:bold;"><?php echo number_format($arrTotal["utility"], 2); ?></td>
        <td style="text-align: center;"></td>
    </tr>
</table>
<br>
