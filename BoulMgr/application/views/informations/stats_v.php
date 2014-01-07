<h2>Statistiques</h2>

<div id="chartdiv" style="height:400px;width:900px; margin-left: auto; margin-right: auto;"></div>

<table id='menu'><thead>
    <tr>
        <th><a href="#" onclick="drawPie(infos_per_week, 'Répartition des ventes cette semaine');">Semaine</a></th>
        <th><a href="#" onclick="drawPie(infos_per_year, 'Répartition des ventes cette année');">Année courante</a></th>
    </tr>
</thead></table>

<dl class="accordion" data-accordion>
    <dd>
        <a href="#panel1">Tableau des ventes de la semaine</a>
        <div id="panel1" class="content">
<?php
	$this->table->set_heading("Produit", "Total des ventes (en unités)", "% des ventes");
	foreach ($total2 as $line)
	{
		$this->table->add_row(
		$line["nom_produit"],
		$line["somme_produit"],
		((number_format($line["somme_produit"]/$grand_total2,2))*100)." %");
	}

	$this->table->add_row("Total", $grand_total2, "100 %");
	echo $this->table->generate();
?>
        </div>
    </dd>
</dl>

<span id="json_per_year" style="display: none;"><?= json_encode($total) ?></span>
<span id="json_per_week" style="display: none;"><?= json_encode($total2) ?></span>
<span id="json_total_per_year" style="display: none;"><?= json_encode($grand_total2) ?></span>
<span id="json_total_per_week" style="display: none;"><?= json_encode($grand_total2) ?></span>

<link rel="stylesheet" type="text/css" href="<?= base_url("/assets/js/jqplot/jquery.jqplot.css") ?>" />
<script defer language="javascript" type="text/javascript" src="<?= base_url("/assets/js/jqplot/jquery.jqplot.min.js") ?>"></script>
<script defer language="javascript" type="text/javascript" src="<?= base_url("/assets/js/jqplot/excanvas.js") ?>"></script>
<script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.pieRenderer.min.js") ?>"></script>
<script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.donutRenderer.min.js") ?>"></script>
<script defer src="<?= base_url("/assets/js/informations/stats.js") ?>"></script>
