<h2><?=$title?></h2>
<h3>Commande n° <?=$commande['id_commande']?></h3>
<p>Commande effectuée le <?=$commande['date_commande']?><br />
par <?=$commande['prenom_client']." ".$commande['nom_client']?>
et livrée le <?=$commande['date_livraison']?>
<div>
    <table class="summary">
        <thead>
            <tr>
                <th>Produit</th>
                <th>Prix unitaire</th>
                <th>Quantité</th>
                <th>Total</th>
            </tr>
        </thead>
        <tfoot>
            <tr>
                <th>TOTAL</th>
                <th></th>
                <th></th>
                <th class="total-price"><?=$commande['prix_total']?></th>
            </tr>
        </tfoot>
        <tbody>
<?php
    $total = 0;
    foreach($produits as $produit) :
        $sous_total = $produit->prix_produit * $produit->quantite_produit_commande;
        $total += $sous_total;   
?>
            <tr>
                <td> <?=$produit->nom_produit?> </td>
                <td class="unit-price"> <?=$produit->prix_produit?> </td>
                <td> <?=$produit->quantite_produit_commande?> </td>
                <td class="subtotal-price"> <?=$sous_total?> </td>
            </tr>
<?php
    endforeach;
    if ($commande['prix_total'] - $total > 0.01) :
?>
            <tr>
                <td>Divers</td>
                <td></td>
                <td></td>
                <td class="subtotal-price"> <?=$commande['prix_total'] - $total?> </td>
            </tr>
<?php
    endif;
?>
        </tbody>
    </table>
</div>
