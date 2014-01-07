<h2><?= $title ?></h2>

<!-- TODO CSS : popup like this one : http://dinbror.dk/bpopup/  -->
<div class="pop_up" id="pop_up"></div>
<div id="detailmatprem">
<?php
if(count($matprem) != 0)
{
    ?>
    <table class="tablematprem"><tr><td>
    <table>
        <?php
            $imgpath = "assets/images/matprem/".$matprem[0]['id_matiere_premiere'].".jpg";
            if(!file_exists(FCPATH . $imgpath))
                $imgpath = "assets/images/empty.jpg";
            $imgaddr = base_url($imgpath);
        ?>
        <tr>
            <td colspan="2"><img src="<?= $imgaddr ?>"/></td>
        </tr>
        <tr>
            <td><?= $matprem[0]['disponibilite_matiere_premiere']." <span id='abrev_unite'>".$matprem[0]['abbreviation_unite']?></span></td>
        </tr>
    </table>

    <div>
        <span id="error"></span>
    </div>
    </td><td>
    <table>
        <tr>
            <th>ID Fournisseur</th>
            <th>Fournisseur</th>
            <th>Prix (en €)</th>
            <th></th>
        </tr>
    <?php

    foreach($fournisseur as $result) {
        $id_fourn = $result['id_fournisseur'];
        ?>
            <tr>
                <td><?= $result['id_fournisseur'] ?></td>
                <td><?= anchor("fournisseurs/profil/".$id_fourn, $result['nom_fournisseur'], "id='nom_fourn_".$id_fourn."'") ?></td>
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
    </td></tr></table>
    <div>

        <table class="tablematprem">
            <caption><b>Commandes</b></caption>
            <tr>
                <th>Numéro de commande</th>
                <th>Date commande</th>
                <th>Fournisseur</th>
                <th>Quantité<br>(en <?= $matprem[0]['nom_unite'] ?>)</th>
                <th>Prix à l'unité<br>(en € par <?= $matprem[0]['nom_unite'] ?>)</th>
                <th>Prix total<br>(en €)</th><th></th>
            </tr>
    <?php

    foreach($commandes as $result) {
        $id_command = $result['id_commande_matiere_premiere'];
        ?>
            <tr>
                <td><?= $result['id_commande_matiere_premiere'] ?></td>
                <td><?= $result['date_commande_matiere_premiere'] ?></td>
                <td><?= anchor("fournisseurs/profil/".$result['id_fournisseur'], $result['nom_fournisseur'], "id='nom_fourn_command".$id_command."'") ?></td>
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

    <div>

        <table class="tablematprem">
            <caption><b>Est utilisé(e) pour :</b></caption>
            <tr>
                <th>Nom du produit</th>
                <th>Quantité<br>(en <?= $matprem[0]['nom_unite'] ?>)</th>
            </tr>
    <?php
    foreach($produits as $result) {
        $id_produit = $result['id_produit'];
        ?>
            <tr>
                <td><?= $result['nom_produit'] ?></td>
                <td><?= $result['quantite_matiere_premiere_produit'] ?></td>
            </tr>
        <?php
    }
    if($produits === [])
    { ?>
        <tr>
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
    </div>
    <span id="idMatprem" style="display: none;"><?= $matprem[0]["id_matiere_premiere"] ?></span>
    <span id="base_url" style="display:none"><?= base_url() ?></span>
    <script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>
    <script defer src="<?= base_url("/assets/js/stocks/matprem_detail.js") ?>"></script>
    <script defer src="<?= base_url("/assets/js/popup_confirm.js") ?>"></script>
<?php

/* End of file matprem_v.php */
/* Location: ./application/view/stocks/matprem_v.php */
