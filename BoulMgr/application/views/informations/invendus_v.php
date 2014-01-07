<h2>Invendus</h2>

<?php
if(count($invendus) != 0)
{
    ?>

    <!-- TODO CSS : Bold, or red color, something to alert the user !-->
    <div>
        <span id="error"></span>
    </div>

    <div id="chartdiv" style="height:400px;width:900px; margin-left: auto; margin-right: auto;"></div>

    <table>
        <tr>
            <th>Produits</th>
            <th>Invendus</th>
            <th>Date Production</th>
        </tr>
    <?php

    foreach($invendus as $result)
    {
        ?>
        <tr>
            <td><?= $result["nom_produit"] ?></td>
            <td><?= $result["quantite"] ?></td>
            <td><?= $result["date_invendu"] ?></td>
        </tr>
        <?php
    }
    echo('</table>');
}

else
{
    echo('Aucune matière première existante.');
}

?>

    <span id="base_url" style="display:none"><?= base_url() ?></span>
    <link rel="stylesheet" type="text/css" href="jquery.jqplot.css" />
    <script defer src="<?= base_url("/assets/js/informations/invendus.js") ?>"></script>
    <script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>
    <script defer language="javascript" type="text/javascript" src="<?= base_url("/assets/js/jqplot/jquery.jqplot.min.js") ?>"></script>
    <script defer language="javascript" type="text/javascript" src="<?= base_url("/assets/js/jqplot/excanvas.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.dateAxisRenderer.min.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.highlighter.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.canvasTextRenderer.min.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.barRenderer.min.js") ?>"></script>

<?php
/* End of file invendus_v.php */
/* Location: ./application/view/informations/invendus_v.php */
