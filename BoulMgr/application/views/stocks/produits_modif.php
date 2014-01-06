<h2>Modifier un produit</h2>
<!-- CSS à faire pour cette page
Un formulaire classique avec des champs alignés avec les labels à gauche des input text.
-->

<?php
echo '<div id="addproduct">';
echo validation_errors();

echo form_open('stocks/produits/modifproduit');

echo form_hidden('id_produit',$produit['id_produit']);
echo '<table><tr><td>';
echo form_label('Nom du produit : ', 'nom');
echo '</td><td>';
echo form_input('nom', $produit['nom_produit']);
echo'</td></tr><tr><td>';

echo form_label('Prix : ', 'prix');
echo '</td><td>';
echo form_input('prix', $produit['prix_produit']);
echo '</td></tr><tr><td>';

echo form_label('Temps de préparation : ', 'temps');
echo '</td><td>';
echo form_input('temps', $produit['temps_preparation_produit']);
echo '</td></tr>';
echo '<tr><td colspan="2"><div id="submitaddproduct">';
echo form_submit("add", "Modifier");
echo '</div></td></tr></table>';
echo form_close();
echo '</div>';
?>
