<h2><?=$title?></h2>
<h3>Vente n° <?=$vente['id_vente']?></h3>
<p>Vente effectuée le <?=$vente['date_vente']?>
<?php if ($vente['id_client']) : ?>
 par <?=$vente['prenom_client']." ".$vente['nom_client']?>
<?php endif; ?>
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
                <th class="total-price"><?=$vente['prix_vente']?></th>
            </tr>
        </tfoot>
        <tbody>
<?php
    $total = 0;
    foreach($produits as $produit) :
        $sous_total = $produit->prix_produit * $produit->quantite_produit_vente;
        $total += $sous_total;   
?>
            <tr>
                <td> <?=$produit->nom_produit?> </td>
                <td class="unit-price"> <?=$produit->prix_produit?> </td>
                <td> <?=$produit->quantite_produit_vente?> </td>
                <td class="subtotal-price"> <?=$sous_total?> </td>
            </tr>
<?php
    endforeach;
    if ($vente['prix_vente'] - $total > 0.01) :
?>
            <tr>
                <td>Divers</td>
                <td></td>
                <td></td>
                <td class="subtotal-price"> <?=$vente['prix_vente'] - $total?> </td>
            </tr>
<?php
    endif;
?>
        </tbody>
    </table>
</div>
