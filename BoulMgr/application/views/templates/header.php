<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?> | Boulangerie Manager</title>
        <link rel=stylesheet type="text/css" href="<?= base_url("/assets/css/normalize.css") ?>">
        <link rel=stylesheet type="text/css" href="<?= base_url("/assets/css/foundation.css") ?>">

    </head>

    <body>
        <nav class="top-bar" data-topbar>
            <ul class="title-area">
                <li class="name">
                    <h1><a href=<?= '"'.base_url().'"'?>>Boulangerie Manager</a></h1>
                </li>
            </ul>

            <section class="top-bar-section">
                <ul>
                    <li class="has-dropdown not-click">
                        <a href="#">Ventes et Commandes</a>

                        <ul class="dropdown">
                            <li>
                                <?= '<a href="'.site_url().'/commerce/vente">Ventes</a>' ?>
                            </li>

                            <li>
                                <a href="#">Commandes</a>
                            </li>
                        </ul>
                    </li>

                    <li class="has-dropdown not-click">
                        <a href="#">Informations</a>

                        <ul class="dropdown">
                            <li>
                                <a href="#">Statistiques</a>
                            </li>

                            <li>
                                <a href="#">Invendus</a>
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
        <div id="content">
