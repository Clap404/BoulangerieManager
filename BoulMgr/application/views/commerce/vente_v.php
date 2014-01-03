<div class="row" id="teest">



<h2><?=$title?></h2>
    <div class="small-6 small-centered columns">
<a href="<?=site_url()?>/commerce/vente/form">
    <button id="tiquet">Enregistrer un nouveau tiquet</button>
</a>
<div>
<?php
    $this->table->set_heading('Date', 'Prix total', 'Client', 'Action');

    foreach ($ventes as $value) {
        if ($value->today === "Y") {
            $action = '<a href="'.site_url().'/commerce/vente/form/'.$value->id_vente.'"> <button>modifier</button> </a>';
        } else {
            $action = '<a href="'.site_url().'/commerce/vente/archive/'.$value->id_vente.'"> <button>afficher</button> </a>';
        }

        $this->table->add_row(
            $value->date_vente,
            $value->prix_vente,
            $value->nom_client." ".$value->prenom_client,
            $action
        );
    }

    echo $this->table->generate(); 
?>
</div>
    </div>
</div>