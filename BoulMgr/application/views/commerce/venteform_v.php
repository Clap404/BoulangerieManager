<div class="row">
    <div class="small-8 columns">
        <div class="product-list">
            <h2>Les produits</h2>
            <?php foreach ($produits as $produit): ?>
            <div class="product" id="product-<?=$produit['id_produit']?>" name="<?=$produit['id_produit']?>">

                <h3 class="product-name"><?=$produit['nom_produit']?></h3>
                <img onclick="addQtyToProduct(1, <?=$produit['id_produit']?>);" src="<?=$root?>/assets/images/produit/<?=$produit['id_produit']?>.jpg" />

                <br />
                <button class="minus" onclick="addQtyToProduct(-1, <?=$produit['id_produit']?>);">-</button>
                <button class="plus" onclick="addQtyToProduct(1, <?=$produit['id_produit']?>);">+</button>
                <input class="qty" type="text" value="0" onchange="populateTable();" maxlength="2" />
                <button class="empty" onclick="addQtyToProduct(-99, <?=$produit['id_produit']?>);">0</button>
                <br />
                <span class="prix" value="<?=$produit['prix_produit']?>"></span>
                <span class="dispo" value="<?=$produit['disponibilite_produit']?>"></span>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="small-4 columns">
        <div class="cart">
            <h2>La selection</h2>
            <div id="mobile">
            <table class="summary">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Prix total</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th>TOTAL</th>
                        <th></th>
                        <th class="total-quantity"></th>
                        <th class="total-price"></th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td class="item-name">Pas de produit sélectionné</td>
                        <td></td>
                        <td class="quantity"></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <select id="client">
                <option value="null">--  Choisissez un client</option>
<?php foreach($clients as $client) :?>
                <option <?php echo($client->id_client === $cli['id_client'] ? 'selected="selected"' : "")?> value="<?=$client->id_client?>"><?=$client->nom_client?> <?=$client->prenom_client?></option>
<?php endforeach;?>
            </select>
            <a href="<?=site_url()?>/commerce/vente/">
                <button>Annuler</button>
            </a>
            <button onclick="resetAll();">RAZ</button>
            <button onclick="saveTicket();">Envoyer</button>
                </div>
        </div>
    </div>
</div>

<script src="<?=$root?>/assets/js/vente.js"></script>
<script defer>
<?php foreach($prods_commande as $p) :?>
    var disp = parseInt(document.querySelector("#product-" + <?=$p->id_produit?> + " .dispo").getAttribute("value"), 10);
    document.querySelector("#product-" + <?=$p->id_produit?> + " .dispo").setAttribute("value", disp + <?=$p->id_produit?>);
    addQtyToProduct(<?=$p->quantite_produit_vente?>, <?=$p->id_produit?>);
<?php endforeach;?>
    var id_vente = <?=$id_vente?>;
    var rootURL = "<?=site_url()?>";
</script>
