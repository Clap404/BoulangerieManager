<div id="container">
	<h1>Bienvenue à la boulanger</h1>
  <h2>Tableau de bord</h2>

  <div class="row">
    <div class="large-3 columns">
      <div class="panel">
        <h3><a href="<?=$root?>index.php/stocks/matprem">Matières premières</a></h3>
        <?php if (count($lowmatprem) === 0) :?>
        <p>
          Toutes vos matières premières sont disponibles en quantité suffisante
        </p>
        <?php endif; ?>
        <?php foreach($lowmatprem as $lm) :?>
        <p>
          Vous manquez  de <?=$lm->nom_matiere_premiere?> :
          achetez en à <?=$lm->nom_fournisseur?>
          pour <?=$lm->minprix?> €
        </p>
        <?php endforeach; ?>
      </div>      
    </div>
    <div class="large-6 columns">
      <div class="panel">
        <h3><a href="<?=$root?>index.php/stocks/production">Production</a></h3>
        <?php if (count($productip) === 0) :?>
        <p>
          Vous n'avez pas de commande particulière à honorer, vous pouvez rester
          dans un régime de production normal.
        </p>
        <?php endif; ?>
        <?php foreach($productip as $pt) :?>
        <p>
            Attention à votre production de <?=$pt->nom_produit?> :
            vous devrez en livrer <?=$pt->commande?> aujourd'hui
            (vous en avez déjà produit <?=$pt->prod?>)
        </p>
        <?php endforeach; ?>
      </div>      
    </div>
    <div class="large-3 columns">
      <div class="panel">
        <h3><a href="<?=$root?>index.php/stocks/produits">Produits</a></h3>
        <?php if (count($prodtip) === 0) :?>
        <p> Pas de vente ce jour de la semaine ! </p>
        <?php else :?>
        <p> Les meilleures vente de ce jour de la semaine sont : </p>
        <?php endif; ?>
          <ul>
          <?php foreach($prodtip as $pp) :?>
            <li>
            <?=$pp->nom_produit?> : <?=$pp->vendus?> unités vendues 
            </li>
          <?php endforeach; ?>
          </ul>
      </div>      
    </div>
  </div>
  <div class="row">
    <div class="large-6 columns">
      <div class="panel">
        <h3><a href="<?=$root?>index.php/commerce/vente">Ventes</a></h3>
        <?php if (count($sales) === 0) :?>
        <p> Vous n'avez pas encore effectué de ventes aujourd'hui </p>
        <?php else:?>
        <p>Aujourd'hui, vous avez vendu :<p>
        <?php endif; ?>
        <ul>
          <?php foreach($sales as $sl) :?>
            <li>
            <?=$sl->nom_produit?> : <?=$sl->vendus?> unités vendues 
            </li>
          <?php endforeach; ?>
        </ul>
      </div>      
    </div>
    <div class="large-6 columns">
      <div class="panel">
        <h3><a href="<?=$root?>index.php/commerce/commande">Commandes</a></h3>
        <?php if (count($productip) === 0) :?>
        <p> Vous n'avez pas de commande à livrer aujourd'hui. </p>
        <?php else :?>
        <p>Vous avez <?=count($todayscommande)?> commande(s) à livrer aujourd'hui</p>
        <?php endif; ?>
        <ul>
          <?php foreach($todayscommande as $tc) :?>
            <li>
            <?=$tc->heure?> : commande pour <?=$tc->client?> à <?=$tc->adresse?>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>
    </div>
  </div>
</div>
