<h2><?=$title?></h2>

<div class="small-6 small-centered columns">
    <div id="tiquet">
        <a class="button radius round" href="<?=site_url()?>/commerce/commande/form">
            Enregistrer une nouvelle commande
        </a>
    </div>
    <div>
        <h3>Commandes en cours</h3>
        <?php
            $this->table->set_heading('Date livraison', 'Date commande', 'Prix total', 'Client', 'Action');

            foreach ($commandes as $value) {
                if ($value->finished === "Y") {
                    continue;
                }
                $this->table->add_row(
                    $value->date_livraison,
                    $value->date_commande,
                    $value->prix_total,
                    $value->nom_client." ".$value->prenom_client,
                    '<a href="'.site_url().'/commerce/commande/form/'.$value->id_commande.'"> <button class="smallbutton">Modifier</button> </a>'
                );
            }

            echo $this->table->generate(); 
            $this->table->clear();
        ?>
    </div>
    <div id="commandfin">
        <h3>Commandes finalisées</h3>
        <?php
            $this->table->set_heading('Date livraison', 'Date commande', 'Prix total', 'Client', 'Action');

            foreach ($commandes as $value) {
                if ($value->finished === "N") {
                    continue;
                }
                $this->table->add_row(
                    $value->date_livraison,
                    $value->date_commande,
                    $value->prix_total,
                    $value->nom_client." ".$value->prenom_client,
                    '<a href="'.site_url().'/commerce/commande/archive/'.$value->id_commande.'"> <button class="smallbutton">Visualiser</button> </a>'
                );
            }
            echo $this->table->generate(); 
            $this->table->clear();
        ?>
    </div>
</div>
