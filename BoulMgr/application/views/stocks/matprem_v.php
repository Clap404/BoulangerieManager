<h2>Matières premières</h2>

<div class="pop_up" id="pop_up" style="display: none;"></div>

<?php
if(count($matprem) != 0)
{
    ?>
    <!-- TODO CSS : Print on the same line text and button  -->
    <table id="affichage"><tr><td>Afficher les matières non utilisées depuis plus d'un mois :</td>
    <td>
    <div class="switch round">
        <input id="switchOff" name="switch-list" type="radio" checked onclick="switchButtonList(false);">
        <label for="switchOff">Off</label>

        <input id="switchOn" name="switch-list" type="radio" onclick="switchButtonList(true);">
        <label for="switchOn">On</label>
    </div></td></tr></table>

    <div id="addmatprem"><button id="add_matprem" class="button radius round" onclick="popupAddButton();">Ajouter</button></div>

    <!-- TODO CSS : Bold, or red color, something to alert the user !-->
    <div>
        <span id="error"></span>
    </div>

    <table>
        <tr>
            <th>Matière première</th>
            <th>Quantité disponible</th>
            <th></th>
        </tr>
    <?php

    for($i = 0; $i < count($matprem); $i++)
    {
        $result = $matprem[$i];
        $matprem_detailed_adr = site_url("stocks/matprem/detail/".$result['id_matiere_premiere']);
        $idMatprem = $result['id_matiere_premiere'];
        $dispo = $result['disponibilite_matiere_premiere'];

        $date1MonthAgo = new DateTime("now");
        date_sub($date1MonthAgo, date_interval_create_from_date_string('1 month'));
        if(isset($result['last_production']))
            $dateMatprem = new DateTime($result['last_production']);
        else
            $dateMatprem = $date1MonthAgo;

        if($dispo == 0 && $dateMatprem <= $date1MonthAgo)
            echo('<tr class="matpremHiddenItem undispo">');
        else if($dispo == 0)
            echo('<tr class="undispo">');
        else if($dateMatprem < $date1MonthAgo)
            echo('<tr class="matpremHiddenItem">');
        else
            echo('<tr>');
        ?>
                <td>
                    <b><a id="name_<?= $idMatprem ?>" onclick="popupDetailsButton('<?= $idMatprem ?>');"><?= $result['nom_matiere_premiere'] ?></a>
                    <input id="modif_name_input_<?= $idMatprem ?>" style="display:none" onkeydown="if (event.keyCode == 13) document.getElementById('save_button_<?= $idMatprem ?>').click()"></input></b>
                </td>
                <td><?= $dispo." ".$result["abbreviation_unite"] ?></td>
                <td>
                    <button class="smallbutton" id="modif_button_<?= $idMatprem ?>" onclick="switch2Modify('<?= $idMatprem ?>');">Modifier</button>
                    <button class="smallbutton" style="display:none" id="save_button_<?= $idMatprem ?>" onclick="saveModif('<?= $idMatprem ?>');">Sauvegarder</button>
                    <button class="smallbutton" style="display:none" id="cancel_button_<?= $idMatprem ?>" onclick="back2Normal('<?= $idMatprem ?>');">Annuler</button>
                </td>
            </tr>
        <?php
    }

    if($matprem === [])
    { ?>
        <tr>
           <td></td>
           <td></td>
           <td></td>
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

    <span id="base_url"><?= base_url() ?></span>
    <script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>
    <script defer src="<?= base_url("/assets/js/stocks/matprem.js") ?>"></script>

<?php
/* End of file matprem_v.php */
/* Location: ./application/view/stocks/matprem_v.php */
