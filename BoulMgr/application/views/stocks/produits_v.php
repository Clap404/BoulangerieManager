<h2>Produits</h2>

<div class="pop_up" id="pop_up" style="display: none;"></div>

<div id="addprod">
<a class="button radius round" href=<?='"'.site_url().'/stocks/produits/ajoutproduit"'?>>
    <div class="profil" width="400" height="200">
        Ajouter un nouveau produit
    </div>
</a>
</div>
<div id="profils">
<?php foreach($produits as $info): ?>


    <div class="profil">
        <table>
            <caption>
                <h4><?= $info['nom_produit'] ?></h4></caption>
            <tr><td>
                    <?php echo '<img src="'.base_url().'assets/images/produit/'.$info['id_produit'].'.jpg" />' ?>
                </td><td><div class="info">
                        Prix : <?= $info['prix_produit'] ?> €<br />
                        Quantité : <?= $info['disponibilite_produit'] ?> pièces<br/>
                        Temps de préparation : <?= $info['temps_preparation_produit'] ?> minutes<br/>
                    </div></td></td></tr><tr><td colspan="2" id="profilbutton">
                    <a id="modif" href=<?= '"'.site_url().'/stocks/produits/modifproduit/'.$info['id_produit'].'"'?>><button>Modifier</button></a><a onclick="deleteProduct(<?= "'".site_url()."/stocks/produits/remove/".$info['id_produit']."'"?>);"><button>Supprimer</button></a></td></tr>
        </table>
    </div>

<?php endforeach; ?>
</div>

<script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>
<script defer src="<?= base_url("/assets/js/popup_confirm.js") ?>"></script>
<script defer src="<?= base_url("/assets/js/stocks/produits.js") ?>"></script>
