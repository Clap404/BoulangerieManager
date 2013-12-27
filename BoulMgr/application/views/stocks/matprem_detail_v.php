<h3><?= $title ?></h3>

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
            <td><?= $matprem[0]['disponibilite_matiere_premiere']." ".$matprem[0]['abbreviation_unite']?> </td>
        </tr>
    </table>

    <table style="margin-top: 10px;">
        <tr>
            <th>ID Fournisseur</th>
            <th>Fournisseur</th>
            <th>Prix</th>
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
    ?>
    </table>

    <div>
        <b>Commandes</b>
        <table style="margin-top: 10px;">
            <tr>
                <th>Numéro de commande</th>
                <th>Date commande</th>
                <th>Fournisseur</th>
                <th>Quantité</th>
                <th>Prix à l'unité</th>
                <th>Prix total</th>
            </tr>
    <?php

    foreach($commandes as $result) {
        ?>
            <tr>
                <td><?= $result['id_commande_matiere_premiere'] ?></td>
                <td><?= $result['date_commande_matiere_premiere'] ?></td>
                <td><?= $result['id_fournisseur'] ?></td>
                <td><?= $result['quantite_matiere_premiere'] ?></td>
                <td><?= $result['prix_unite_matiere_premiere'] ?></td>
                <td><?= $result['quantite_matiere_premiere'] * $result['prix_unite_matiere_premiere'] ?></td>
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

/* End of file matprem_v.php */
/* Location: ./application/view/stocks/matprem_v.php */
