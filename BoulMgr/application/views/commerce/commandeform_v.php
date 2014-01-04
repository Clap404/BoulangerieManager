<div class="row">
  <div class="small-8 columns">
    <div class="product-list">
      <h2>Les produits</h2>
      <?php foreach ($produits as $produit): ?>
        <div class="product" id="product-<?=$produit['id_produit']?>"
            name="<?=$produit['id_produit']?>">
          <h3 class="product-name"><?=$produit['nom_produit']?></h3>
          <img onclick="addQtyToProduct(1, <?=$produit['id_produit']?>);"
              src="<?=$root?>/assets/images/produit/<?=$produit['id_produit']?>.jpg"
          />
          <br />
          <button onclick="addQtyToProduct(-1, <?=$produit['id_produit']?>);"
            class="minus">-
          </button>
          <button onclick="addQtyToProduct(1, <?=$produit['id_produit']?>);"
            class="plus">+
          </button>
          <input class="qty" type="text" value="0" onchange="populateTable();"
            maxlength="3"
          />
          <button onclick="addQtyToProduct(-999, <?=$produit['id_produit']?>);"
            class="empty">0
          </button>
          <br />
          <span class="prix" value="<?=$produit['prix_produit']?>"></span>
        </div>
      <?php endforeach; ?>
    </div>
  </div>
  <div class="small-4 columns">
    <div class="cart">
      <h2>La selection</h2>
      <div id="mobile">
        <div id="dim">
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
          <select id="client" onchange="updateAdresses();">
            <option value="null">--  Choisissez un client</option>
            <?php foreach($clients as $client) :?>
              <option
                <?=$client->id_client === $cli['id_client'] ? 'selected="selected"':""?>
                value="<?=$client->id_client?>">
                <?=$client->nom_client?> <?=$client->prenom_client?>
              </option>
            <?php endforeach;?>
          </select>
          <select id="adresse" >
            <option>Choisissez une adresse de livraison</option>
          </select>
        </div>
        <input type="text" placeholder="Selectionnez une date" id="datepicker" />
        <a href="<?=site_url()?>/commerce/commande/">
          <button>Annuler</button>
        </a>
        <button onclick="resetAll();">RAZ</button>
        <button onclick="saveTicket();">Envoyer</button>
      </div>
    </div>
  </div>
</div>

<script src="<?=$root?>/assets/js/commande.js"></script>
<script defer src="<?=$root?>/assets/js/jquery.datetimepicker.js"></script>
<script>
<?php foreach($prods_commande as $p) :?>
    addQtyToProduct(<?=$p->quantite_produit_commande?>, <?=$p->id_produit?>);
<?php endforeach;?>
var id_commande = <?=$id_commande?>;
var rootURL = "<?=site_url()?>";
document.querySelector('#datepicker').value = "<?=$date?>".split(" ").
    map(function(x) {
        if (x.match(/[0-9]{2}:[0-9]{2}:[0-9]{2}/)) {
            return x. substr(0, 5);
        }
        return x.split('-').reverse().join("/")
    }).join(" ");
<?php if($adresse !== 0) :?>
setTimeout( function () {
    updateAdresses(parseInt(<?=$adresse?> , 10));
}, 10 /* ce hack dégueulasse : > */);
<?php endif;?>
</script>
<link rel="stylesheet" type="text/css"
  href="<?=$root?>/assets/css/jquery.datetimepicker.css" />
