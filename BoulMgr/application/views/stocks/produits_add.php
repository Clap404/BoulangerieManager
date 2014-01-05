<h2>Ajouter un produit</h2>

<!-- CSS à faire pour cette page
Un formulaire classique avec des champs alignés avec les labels à gauche des input text.
-->

<?php
echo '<div id="addproduct">';
echo validation_errors();

echo form_open_multipart('stocks/produits/ajoutproduit');
echo '<table><tr><td>';
echo form_label('Nom du produit : ', 'nom');
echo '</td><td>';
echo form_input('nom');
echo'</td></tr><tr><td>';

echo form_label('Prix : ', 'prix');
echo '</td><td>';
echo form_input('prix');
echo '</td></tr><tr><td>';
echo form_label('Temps de préparation : ', 'temps');
echo '</td><td>';
echo form_input('temps');
echo '</td></tr><tr><td>';
echo form_label('Image : ', 'image');
echo '</td><td>';
echo form_upload('image');
echo '</td></tr>';
echo '<tr><td colspan="2"><div id="submitaddproduct">';
echo form_submit("add", "Ajouter");
echo '</div></td></tr></table>';
echo form_close();
echo '</div>';
?>
