<h3>Matières premières</h3>

<?php
if(count($matprem) != 0)
{
    ?>
    <span id="error"></span>
    <table>
        <tr>
            <td>Matière première</td>
            <td>Quantité disponible</td>
            <td></td>
        </tr>
    <?php

    foreach($matprem as $result) {
        $matprem_detailed_adr = site_url("stocks/matprem/detail/".$result['id_matiere_premiere']);
        $idMatprem = $result['id_matiere_premiere'];
        /* For the debug :
            <td><?= $result['id_matiere_premiere'] ?></td> */
        ?>
            <tr>
                <td>
                    <?= anchor($matprem_detailed_adr, $result['nom_matiere_premiere'], "id='name_".$idMatprem."'") ?>
                    <input id="modif_name_input_<?= $idMatprem ?>" style="display:none" onkeydown="if (event.keyCode == 13) document.getElementById('save_button_<?= $idMatprem ?>').click()"></input>
                </td>
                <td><?= $result['disponibilite_matiere_premiere'] ?> pièces</td>
                <td>
                    <button id="modif_button_<?= $idMatprem ?>" onclick="switch2Modify('<?= $idMatprem ?>');">Modifier</button>
                    <button style="display:none" id="save_button_<?= $idMatprem ?>" onclick="saveModif('<?= $idMatprem ?>');">Sauvegarder</button>
                    <button style="display:none" id="cancel_button_<?= $idMatprem ?>" onclick="back2Normal('<?= $idMatprem ?>');">Annuler</button>
                </td>
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

    <script src="<?= base_url("/assets/js/stocks/matprem.js") ?>"></script>

<?php
/* End of file matprem_v.php */
/* Location: ./application/view/stocks/matprem_v.php */
