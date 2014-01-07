<h2>Statistiques</h2>

<?php

	$this->table->set_heading("Produit", "Ventes", "% des ventes");
	foreach ($total as $line) 
	{
		$this->table->add_row(
		$line["nom_produit"],
		$line["somme_produit"]." €", 
		((number_format($line["somme_produit"]/$grand_total,2))*100)." %");
	}
	
	$this->table->add_row("Total", $grand_total." €");
	echo $this->table->generate(); 
?>