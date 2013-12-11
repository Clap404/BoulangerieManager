        <div class="product-list">
            <h2>Les produits</h2>
            <?php foreach ($produits as $produit): ?>
            <div class="product" id="product-<?=$produit['id_produit']?>" name="<?=$produit['id_produit']?>">
                <h3 class="product-name"><?=$produit['nom_produit']?></h3>
                <img onclick="addQtyToProduct(1, <?=$produit['id_produit']?>);" src="<?=$root?>/assets/images/produit/<?=$produit['id_produit']?>.jpg" />
                <br />
                <button class="empty" onclick="addQtyToProduct(-99, <?=$produit['id_produit']?>);"></button>
                <button class="minus" onclick="addQtyToProduct(-1, <?=$produit['id_produit']?>);"></button>
                <input class="qty" type="text" value="0" onchange="checkIfNewActive();" maxlength="2"/>
                <button class="plus" onclick="addQtyToProduct(1, <?=$produit['id_produit']?>);"></button>
                <br />
                <span class="prix" value="<?=$produit['prix_unitaire']?>"></span>
            </div>
            <?php endforeach; ?>
        </div>
        <div class="cart">
            <h2>La selection</h2>
            <table class="summary">
                <thead>
                    <tr>
                        <th>Nom</th>
                        <th>Prix unitaire</th>
                        <th>Quantité</th>
                        <th>Prix total</th>
                    </tr>
                </thead>
                <tfoot>
                    <tr>
                        <th> TOTAL </th>
                        <th></th>
                        <th class="total-quantity"></th>
                        <th class="total-price"></th>
                    </tr>
                </tfoot>
                <tbody>
                    <tr>
                        <td class="item-name">Pas de produit sélectionné</td>
                        <td></td>
                        <td class="quantity"></td>
                        <td></td>
                    </tr>
                </tbody>
            </table>
            <button>Annuler</button>
            <button onclick="resetAll();">RAZ</button>
            <button>Envoyer</button>
        </div>

    <script src="<?=$root?>/assets/js/vente.js"></script>

<!--
    Style temporaire à supprimer quand on aura un joli CSS
    Pour l'instant je le laisse pour que Maxime puisse voir les
    trucs dont j'ai besoin (notamment les trucs :after qui affichent
    le symbole euro sans que ça soit chiant à parser avec le JS)
-->
    <style>
        * {
            margin : 0;
            padding : 0;
        }
        body {
            background-color : #fdf6e3;
            color : #073642;
        }
        h1, h2 {
            text-align : center;
            display : block;
        }
        main {
            position : relative;
        }
        .cart {
            position : absolute;
            background-color : #eee8d5;
            top : 0;
            right : 0;
            width : 34%;
            min-width : 400px;
            margin-left : 20px;
            margin-right : 0;
            display : block;
            text-align: center;
        }

        .summary td, .summary th {
            border : 1px solid #073642;
        }
        .summary {
            margin : 5px;
            width : 98%;
            background-color : #fdf6e3;
            border-collapse: collapse;
        }
        .product-list {
            top : 0;
            left : 0;
            max-width : 64%;
            margin-left : 0;
            margin-right : 410px;
            background-color: #eee8d5;
        }
        .product-name {
            margin-bottom: 0;
            margin-top: 0;
            padding-bottom: 0;
            padding-top: 0;
        }
        .product, .product-active {
            text-align: center;
            background-color : #fdf6e3;
            display : inline-block;
            height : 200px;
            width : 200px;
            text-decoration: none;
            text-transform: none;
            color : inherit;
            margin-bottom : 2px;
            margin-top : 2px;
        }
        .product-active {
            background-color : #859900;
        }
        .unit-price:after, .subtotal-price:after, .total-price:after {
            content : "\20AC";
        }
        .plus, .minus, .qty, .empty {
            height : 24px;
            width : 24px;
        }
        .empty:after {
            content : "\2205"
        }
        .plus:after {
            content : " + ";
        }
        .minus:after {
            content : " - ";
        }
        .prix {
            display : none;
        }
        img:hover {
            cursor : pointer;
            cursor : hand;
        }
    </style>