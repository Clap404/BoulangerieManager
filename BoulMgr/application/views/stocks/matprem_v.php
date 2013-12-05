<h3>Matières premières</h3>

<?php
if(count($matprem) != 0)
{
    ?>
    <table>
        <tr>
            <td colspan="2">LA PHOTO</td>
        <tr />
        <tr>
            <td colspan="2"><?= $matprem[0]['nom_matiere_premiere'] ?></td>
        <tr />
        <tr>
            <td><?= $matprem[0]['disponibilite_matiere_premiere'] ?> pièces</td>
            <td>- +</td>
        </tr>
    </table>

    <p></p>
    <table>
        <tr>
            <td>ID</td>
            <td>Matière première</td>
            <td>Quantité disponible</td>
        </tr>
    <?php

    foreach($matprem as $result) {
        $matprem_detailed_adr = site_url("stocks/matprem/detail/".$result['id_matiere_premiere']);
        // TODO : Change the cursor in pointer with "cursor: pointer" for the <tr>
        ?>
            <tr onclick="document.location='<?= $matprem_detailed_adr ?>';">
                <td><?= $result['id_matiere_premiere'] ?></td>
                <td><?= anchor($matprem_detailed_adr, $result['nom_matiere_premiere']) ?></td>
                <td><?= $result['disponibilite_matiere_premiere'] ?> pièces</td>
            </tr>
        <?php
    }
    echo('</table>');
}

else
{
    echo('Aucune matière première existante.');
}

/* End of file matprem_v.php */
/* Location: ./application/view/stocks/matprem_v.php */
