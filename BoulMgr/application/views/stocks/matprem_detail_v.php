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
            <td>ID Fournisseur</td>
            <td>Fournisseur</td>
            <td>Prix</td>
        </tr>
    <?php

    foreach($fournisseur as $result) {
        ?>
            <tr>
                <td><?= $result['id_fournisseur'] ?></td>
                <td><?= $result['nom_fournisseur'] ?></td>
                <td><?= $result['prix'] ?></td>
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
