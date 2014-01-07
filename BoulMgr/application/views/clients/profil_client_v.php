<h2><?=$title?></h2>
<div class="row">
    <div class="small-6 large-4 columns">
<h3>adresses</h3>
<div class="fournisseur">
<?php
    $this->table->set_heading('Adresse', 'Code postal', 'Ville', 'Description');

    foreach ($adresses as $value) {
        $this->table->add_row(
            $value->numero_voie_adresse ." ". $value->nom_type_voie ." ". $value->nom_voie_adresse,
            $value->code_postal,
            $value->nom_ville,
            $value->description_adresse
        );
    }

    echo $this->table->generate(); 
?>
</div>
    </div>




    <div class="small-4 large-4 columns">
<h3>numéros de téléphone</h3>
<div class="fournisseur">
  
<?php
    $this->table->set_heading('Numéro', 'Description');

    foreach ($telephones as $value) {
        $this->table->add_row(
            $value->numero_telephone,
            $value->description_telephone
        );
    }

    echo $this->table->generate(); 
?>

</div>
</div>

</div>


<h3>Commandes</h3>
<div id="commandes">
<div class="fournisseur">
    <?php
    $this->table->set_heading('Numero','Prix','Date de la commande', 'Date de livraison', 'Adresse de livraison');

    foreach($commandes as $value) {
        $this->table->add_row (
            $value['id_commande'],
            $value['prix_total'].'€',
            $value['date_commande'],
            $value['date_livraison'],
            $value['numero_voie_adresse'].' '.$value['nom_type_voie'].' '.$value['nom_voie_adresse'].', '.$value['code_postal'].' '.$value['nom_ville']
        );
    }

    echo $this->table->generate();
    ?>
</div>
</div>