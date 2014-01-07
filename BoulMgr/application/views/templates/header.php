<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?> | Boulangerie Manager</title>
        <link rel="icon" href="<?= base_url("/assets/images/boulangerie_icon.jpg") ?>">
        <link rel=stylesheet type="text/css" href="<?= base_url("/assets/css/normalize.css") ?>">
        <link rel=stylesheet type="text/css" href="<?= base_url("/assets/css/foundation.css") ?>">
        <link rel=stylesheet type="text/css" href="<?= base_url("/assets/css/style.css") ?>">


    </head>

    <body>
    <div class="fixed">
        <nav class="top-bar" data-topbar>
            <ul class="title-area">
                <li class="name">
                    <h1><a href=<?= '"'.site_url().'"'?>>Boulangerie Manager</a></h1>
                </li>
                <li class="toggle-topbar menu-icon"><a href="#">Menu</a></li>
            </ul>

            <section class="top-bar-section">
                <ul>
                    <li class="divider"></li>
                    <li class="has-dropdown not-click">
                        <a href="#">Ventes et Commandes</a>

                        <ul class="dropdown">
                            <li>
                                <a href="<?=site_url()?>/commerce/vente">Ventes</a>
                            </li>

                            <li>
                                <a href="<?=site_url()?>/commerce/commande">Commandes</a>
                            </li>
                        </ul>
                    </li>

                    <li class="has-dropdown not-click">
                        <a href="#">Informations</a>

                        <ul class="dropdown">
                            <li>
                                <a href="<?=site_url("informations/stats")?>">Statistiques</a>
                            </li>

                            <li>
                                <a href="<?=site_url("informations/invendus")?>">Invendus</a>
                            </li>
                        </ul>
                    </li>

                    <li class="has-dropdown not-click">
                        <a href="#">Stocks</a>

                        <ul class="dropdown">
                            <li>
                                <?= '<a href="'.site_url().'/stocks/matprem">Matières Premières</a>' ?>
                            </li>

                            <li>
                                <?= '<a href="'.site_url().'/stocks/produits">Produits</a>' ?>
                            </li>

                            <li>
                                <?= '<a href="'.site_url().'/stocks/production">Production</a>' ?>

                        </ul>
                    </li>

                    <li class="has-dropdown not-click">
                        <a href="#">Clients et Fournisseurs</a>

                        <ul class="dropdown">
                            <li>
                                <?= '<a href="'.site_url().'/clients">Clients</a>' ?>
                            </li>

                            <li>
                                <?= '<a href="'.site_url().'/fournisseurs">Fournisseurs</a>' ?>
                            </li>
                        </ul>
                    </li>
                </ul>
            </section>
        </nav>
    </div>
        <div id="content">
