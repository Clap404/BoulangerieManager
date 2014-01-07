<h2>Statistiques</h2>

<?php

	echo '<hr>';
	$this->table->set_caption("Ventes depuis le début de l'année");
	$this->table->set_heading("Produit", "Total des ventes", "% des ventes");
	foreach ($total as $line) 
	{
		$this->table->add_row(
		$line["nom_produit"],
		$line["somme_produit"]." €", 
		((number_format($line["somme_produit"]/$grand_total,2))*100)." %");
	}
	
	$this->table->add_row("Total", $grand_total." €", "100 %");
	echo $this->table->generate(); 


	echo '<br><hr><br>';

	$this->table->set_caption("Ventes depuis le début de la semaine");
	$this->table->set_heading("Produit", "Total des ventes", "% des ventes");
	foreach ($total2 as $line) 
	{
		$this->table->add_row(
		$line["nom_produit"],
		$line["somme_produit"]." €", 
		((number_format($line["somme_produit"]/$grand_total2,2))*100)." %");
	}
	
	$this->table->add_row("Total", $grand_total2." €", "100 %");
	echo $this->table->generate(); 
?>
