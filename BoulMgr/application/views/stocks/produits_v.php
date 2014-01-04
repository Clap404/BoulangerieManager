<h2>Produits</h2>

<!-- INFO pour le CSS de cette page
Il faudrait que chaque "produit" soit représenté sous la forme d'une vignette contenant
le nom en haut, la photo en dessous à gauche et les différentes caractéristiques à gauche de la photo.

Pour le lien "ajouter un nouveaux produit" il faut qu'il fasse la même taille que "les vignettes produit", que le background soit du même bleu
que les boutons modifier et supprimer, que les corners soit arrondis et que le texte soit centré, écrit plus gros et avec une police sympa.
Il faudra également qu'au survol de la souris le background devienne bleu foncé (toujours comme les boutons).

-->
<div id="addprod">
<a class="button radius round" href=<?='"'.site_url().'/stocks/produits/ajoutproduit"'?>>
    <div class="profil" width="400" height="200">
        Ajouter un nouveau produit
    </div>
</a>
</div>

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
                    </div></td></td></tr><tr><td>
                    <a href=<?= '"'.site_url().'/stocks/produits/modifproduit/'.$info['id_produit'].'"'?>><button>Modifier</button></a> </td><td><a href=<?= '"'.site_url().'/stocks/produits/remove/'.$info['id_produit'].'"'?>><button>Supprimer</button></a></td></tr>
        </table>
    </div>

<?php endforeach; ?>

