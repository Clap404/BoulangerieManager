<h3><?= $title ?></h3>

<!-- TODO CSS : popup like this one : http://dinbror.dk/bpopup/  -->
<div id="pop_up" style="display: none; width: 600px; height: 400px; padding: 20px; background-color: white;"></div>

<?php
if(count($matprem) != 0)
{
    ?>
    <table>
        <?php
            $imgpath = "assets/images/matprem/".$matprem[0]['id_matiere_premiere'].".jpg";
            $imgaddr = base_url($imgpath);
            if(file_exists(FCPATH . $imgpath)){
        ?>
        <tr>
            <td colspan="2"><img src="<?= $imgaddr ?>"/></td>
        </tr>
        <?php
            }
        ?>
        <tr>
            <td><?= $matprem[0]['disponibilite_matiere_premiere']." <span id='abrev_unite'>".$matprem[0]['abbreviation_unite']?></span></td>
        </tr>
    </table>

    <div>
        <span id="error"></span>
    </div>

    <table style="margin-top: 10px;">
        <tr>
            <th>ID Fournisseur</th>
            <th>Fournisseur</th>
            <th>Prix (en €)</th>
        </tr>
    <?php

    foreach($fournisseur as $result) {
        $id_fourn = $result['id_fournisseur'];
        ?>
            <tr>
                <td><?= $result['id_fournisseur'] ?></td>
                <td id='nom_fourn_<?= $id_fourn ?>'><?= $result['nom_fournisseur'] ?></td>
                <td id='prix_fourn_<?= $id_fourn ?>'><?= $result['prix'] ?></td>
                <td><button onclick="popupButton(<?= $id_fourn ?>);">Commander</button></td>
            </tr>
        <?php
    }
    if($commandes === [])
    { ?>
        <tr>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
        </tr>
      <?php
    }
    ?>
    </table>

    <div>
        <b>Commandes</b>
        <table style="margin-top: 10px;">
            <tr>
                <th>Numéro de commande</th>
                <th>Date commande</th>
                <th>Fournisseur</th>
                <th>Quantité<br>(en <?= $matprem[0]['nom_unite'] ?>)</th>
                <th>Prix à l'unité<br>(en € par <?= $matprem[0]['nom_unite'] ?>)</th>
                <th>Prix total<br>(en €)</th>
            </tr>
    <?php

    foreach($commandes as $result) {
        $id_command = $result['id_commande_matiere_premiere'];
        ?>
            <tr>
                <td><?= $result['id_commande_matiere_premiere'] ?></td>
                <td><?= $result['date_commande_matiere_premiere'] ?></td>
                <td id="nom_fourn_command_<?= $id_command ?>"><?= $result['nom_fournisseur'] ?></td>
                <td id="qte_command_<?= $id_command ?>"><?= $result['quantite_matiere_premiere'] ?></td>
                <td id="prix_unite_command_<?= $id_command ?>"><?= $result['prix_unite_matiere_premiere'] ?></td>
                <td><?= $result['quantite_matiere_premiere'] * $result['prix_unite_matiere_premiere'] ?></td>
                <td>
                    <button id="modify_command_button_<?= $id_command ?>" onclick="modifyCommand(<?= $id_command.','.$result["id_fournisseur"] ?>);">Modifier</button>
                    <button id="delete_command_button_<?= $id_command ?>" onclick="deleteCommand(<?= $id_command ?>);">Supprimer</button>
                </td>
            </tr>
        <?php
    }
    if($commandes === [])
    { ?>
        <tr>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
           <td></td>
        </tr>
      <?php
    }
    ?>
        </table>
    </div>

    <?php
}

else
{
    echo('Aucune matière première existante.');
}

?>
    <span id="idMatprem" style="display: none;"><?= $matprem[0]["id_matiere_premiere"] ?></span>
    <span id="base_url" style="display:none"><?= base_url() ?></span>
    <script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>
    <script defer src="<?= base_url("/assets/js/stocks/matprem_detail.js") ?>"></script>
<?php

/* End of file matprem_v.php */
/* Location: ./application/view/stocks/matprem_v.php */
