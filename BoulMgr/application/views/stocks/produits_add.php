<h2>Ajouter un produit</h2>

<?php

echo validation_errors();

echo form_open_multipart('stocks/produits/ajoutproduit');

echo form_label('Nom du produit : ', 'nom');
echo form_input('nom');

echo form_label('Prix : ', 'prix');
echo form_input('prix');

echo form_label('Temps de préparation : ', 'temps');
echo form_input('temps');

echo form_label('Image : ', 'image');
echo form_upload('image');

echo form_submit("add", "Ajouter");

echo form_close();

?>
