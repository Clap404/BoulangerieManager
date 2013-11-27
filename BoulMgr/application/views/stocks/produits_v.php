<h3>Produits</h3>

<!-- Essai agencement sous forme de cadre -->
<table>
    <tr>
        <td colspan="2">LA PHOTO</td>
    <tr />
    <tr>
        <td colspan="2"><?= $produits[0]['nom_produit'] ?></td>
    <tr />
    <tr>
        <td><?= $produits[0]['prix_unitaire'] ?> €</td>
        <td>- +</td>
    </tr>
    <tr>
        <td><?= $produits[0]['disponibilite_produit'] ?> pièces</td>
        <td>- +</td>
    </tr>
    <tr>
        <td><?= $produits[0]['temps_preparation_produit'] ?> min</td>
    </tr>
</table>
        
</table>
<!-- Fin essai -->

<table>
    <tr>
        <td>ID</td>
        <td>Produit</td>
        <td>Prix unitaire</td>
        <td>Quantité disponible</td>
        <td>Temps de préparation</td>
    </tr>

<?php

foreach($produits as $result) {
    echo '<tr>';
    foreach($result as $data) {
        echo '<td>'.$data.'</td>';
    }
    echo '</tr>';
}
echo '</table>';
?>
