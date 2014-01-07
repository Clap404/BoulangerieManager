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

    <table id='days'><thead>
        <tr>
    <?php
    for($i = 0; $i < count($total); $i++)
    {
        $dayname = strftime('%A', strtotime($total[6 - $i]["date_invendu"]));
        if($total[6-$i]["sum_quantite"] == 0)
        {
            ?>
            <th><?= ucwords($dayname) ?></th>
            <?php
        }
        else
        {
            ?>
            <th><a href="#" onclick="drawPie(<?= $i.",'".$dayname."'"?>);"><?= ucwords($dayname) ?></a></th>
            <?php
        }
    }
    ?>
        <th><a href="#" onclick="drawBar();">Total</a></th>
        </tr>
        </thead>
    </table>
<dl class="accordion" data-accordion>
    <dd>
        <a href="#panel1">Accordion 1</a>
        <div id="panel1" class="content active">
    <table id='invendus'><thead>
        <tr>
            <th>Produits</th>
            <th>Invendus</th>
            <th>Date Production</th>
        </tr></thead>
    <?php
    foreach($invendus as $day)
    {
        foreach($day as $result)
        {
            ?>
            <tr>
                <td><?= $result["nom_produit"] ?></td>
                <td><?= $result["quantite"] ?></td>
                <td><?= $result["date_invendu"] ?></td>
            </tr>
            <?php
        }
    }
    echo('</table>');
}

else
{
    echo('Aucune matière première existante.');
}

?>
        </div>
    </dd>
</dl>
    <span id="base_url" style="display:none"><?= base_url() ?></span>
    <span id="json_total" style="display:none"><?= json_encode($total) ?></span>
    <span id="json_invendus" style="display:none"><?= json_encode($invendus) ?></span>
    <link rel="stylesheet" type="text/css" href="<?= base_url("/assets/js/jqplot/jquery.jqplot.css") ?>" />
    <script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>
    <script defer language="javascript" type="text/javascript" src="<?= base_url("/assets/js/jqplot/jquery.jqplot.min.js") ?>"></script>
    <script defer language="javascript" type="text/javascript" src="<?= base_url("/assets/js/jqplot/excanvas.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.dateAxisRenderer.min.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.highlighter.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.canvasTextRenderer.min.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.canvasAxisTickRenderer.min.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.categoryAxisRenderer.min.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.barRenderer.min.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.pieRenderer.min.js") ?>"></script>
    <script defer type="text/javascript" src="<?= base_url("/assets/js/jqplot/plugins/jqplot.donutRenderer.min.js") ?>"></script>
    <script defer src="<?= base_url("/assets/js/informations/invendus.js") ?>"></script>

<?php
/* End of file invendus_v.php */
/* Location: ./application/view/informations/invendus_v.php */
