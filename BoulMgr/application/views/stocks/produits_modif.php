<h2>Modifier un produit</h2>
<!-- CSS à faire pour cette page
Un formulaire classique avec des champs alignés avec les labels à gauche des input text.
-->

<?php

echo validation_errors();

echo form_open('stocks/produits/modifproduit');

echo form_hidden('id_produit',$produit['id_produit']);

echo form_label('Nom du produit : ', 'nom');
echo form_input('nom', $produit['nom_produit']);

echo form_label('Prix : ', 'prix');
echo form_input('prix', $produit['prix_produit']);

echo form_label('Temps de préparation : ', 'temps');
echo form_input('temps', $produit['temps_preparation_produit']);

echo form_submit("add", "Modifier");

echo form_close();

?>
