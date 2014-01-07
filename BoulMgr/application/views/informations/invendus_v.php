<h2>Invendus</h2>

<?php
if(count($invendus) != 0)
{
    ?>

    <!-- TODO CSS : Bold, or red color, something to alert the user !-->
    <div>
        <span id="error"></span>
    </div>

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
    <script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>

<?php
/* End of file invendus_v.php */
/* Location: ./application/view/informations/invendus_v.php */
