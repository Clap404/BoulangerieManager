<h2>Statistiques</h2>

<table id='bigmenu'><thead>
    <tr>
        <th><a href="#" onclick="switch2Repart();">Répartition des ventes</a></th>
        <th><a href="#" onclick="switch2Hist();">Historique des ventes</a></th>
    </tr>
</thead></table>

<div id="chartdiv" style="height:400px;width:900px; margin-left: auto; margin-right: auto;"></div>

<table id='menu'><thead>
</thead></table>

<dl class="accordion" data-accordion>
    <dd>
        <a href="#panel1">Tableau des ventes de la semaine</a>
        <div id="panel1" class="content">
<?php
	$this->table->set_heading("Produit", "Total des ventes", "% des ventes");
    if($grand_total2 != 0)
    {
        foreach ($total2 as $line)
        {
            $this->table->add_row(
            $line["nom_produit"],
            $line["somme_produit"]." €",
            ((number_format($line["somme_produit"]/$grand_total2,2))*100)." %");
        }

        $this->table->add_row("Total", $grand_total2, "100 %");
    }
        echo $this->table->generate();
?>
        </div>
    </dd>
</dl>

<span id="base_url" style="display:none"><?= base_url() ?></span>
<span id="json_per_year" style="display: none;"><?= json_encode($total) ?></span>
<span id="json_per_week" style="display: none;"><?= json_encode($total2) ?></span>
<span id="json_total_per_year" style="display: none;"><?= json_encode($grand_total2) ?></span>
<span id="json_total_per_week" style="display: none;"><?= json_encode($grand_total2) ?></span>

<link rel="stylesheet" type="text/css" href="<?= base_url("/assets/js/jqplot/jquery.jqplot.css") ?>" />
<script defer language="javascript" type="text/javascript" src="<?= base_url("/assets/js/jqplot/jquery.jqplot.min.js") ?>"></script>
<script defer language="javascript" type="text/javascript" src="<?= base_url("/assets/js/jqplot/excanvas.js") ?>"></script>
<script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.pieRenderer.min.js") ?>"></script>
<script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.donutRenderer.min.js") ?>"></script>
<script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.highlighter.min.js") ?>"></script>
<script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.cursor.min.js") ?>"></script>
<script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.dateAxisRenderer.min.js") ?>"></script>
<script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js") ?>"></script>
<script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.pointLabels.min.js") ?>"></script>
<script defer src="<?= base_url("/assets/js/informations/stats.js") ?>"></script>
