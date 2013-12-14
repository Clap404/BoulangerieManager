<h2>Produits</h2>

<?php foreach($produits as $info): ?>

<div class="profil">
    <h4><?= $info['nom_produit'] ?></h4>
    <?php echo '<img src="'.base_url().'assets/images/produit/'.$info['id_produit'].'.jpg" />' ?>
    <div class="info">
        Prix : <?= $info['prix_produit'] ?> €<br />
        Quantité : <?= $info['disponibilite_produit'] ?> pièces<br/>
        Temps de préparation : <?= $info['temps_preparation_produit'] ?> minutes
    </div>
    <button>Modifier</button><button>Supprimer</button>
</div>

<?php endforeach; ?>
