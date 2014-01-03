var commande = [];

function populateTable() {
    checkValidity();
    var products = document.querySelectorAll(".product-active");
    var totQuant = document.querySelector(".summary tfoot tr .total-quantity");
    var totPrix = document.querySelector(".summary tfoot tr .total-price");
    var tbody = document.createElement("tbody");
    var tr, td, i;
    commande = [];
    if (products.length === 0) {
        tr = document.createElement("tr");
        
        td = document.createElement("td");
        td.className = "item-name";
        td.innerHTML = "Pas de produit sélectionné";
        tr.appendChild(td);

        for (i = 0; i < 3; i ++) {
            td = document.createElement("td");
            tr.appendChild(td);
        }
        tbody.appendChild(tr);
    }
    for (i = 0; i < products.length; i ++) {
        tr = document.createElement("tr");
        var prod = {};
        prod.id = products[i].getAttribute("name");
        prod.nom = products[i].querySelector(".product-name").innerHTML;
        prod.prix = parseFloat(products[i].querySelector(".prix").getAttribute("value"), 10).toFixed(2);
        prod.quantite = parseInt(products[i].querySelector(".qty").value, 10);
        commande.push(prod);

        td = document.createElement("td");
        td.className = "item-name";
        td.innerHTML = prod.nom;
        tr.appendChild(td);

        td = document.createElement("td");
        td.className = "unit-price";
        td.innerHTML = prod.prix;
        tr.appendChild(td);
        
        td = document.createElement("td");
        td.className = "quantity";
        td.innerHTML = prod.quantite;
        tr.appendChild(td);

        td = document.createElement("td");
        td.className = "subtotal-price";
        td.innerHTML = (prod.quantite * prod.prix).toFixed(2);
        tr.appendChild(td);

        tbody.appendChild(tr);
    }
    var total = commande.reduce(function(acc, x) {
        quantite = acc.quantite + x.quantite;
        prix = acc.prix + x.quantite * x.prix;
        return { quantite : quantite, prix : prix };
    }, { quantite : 0, prix : 0});
    document.querySelector(".summary tbody").innerHTML = tbody.innerHTML;
    document.querySelector(".summary tfoot tr .total-quantity").innerHTML = total.quantite.toFixed(2);
    document.querySelector(".summary tfoot tr .total-price").innerHTML = total.prix.toFixed(2);
}

function checkValidity() {
    var products = document.querySelectorAll(".product, .product-active, .product-depleted");
    for (var i = 0; i < products.length; i ++) {
        var val = products[i].children[5].value;
        var dispo = parseInt(products[i].children[9].getAttribute("value"), 10);
        intval = parseInt(val, 10);
        if (intval >= dispo) {
            intval = dispo;
        }
        if (val !== intval.toString() ||
                            typeof intval === 'undefined' ||
                            intval === null ||
                            Number.isNaN(intval) ||
                            intval < 0 ) {

            intval = 0;
            products[i].className = "product";
        } else if (intval === 0) {
            products[i].className = "product";
        } else {
            products[i].className = "product-active";
        }
        if (intval >= dispo) {
            intval = dispo;
            products[i].className += " product-depleted";
        }
        products[i].children[5].value = intval;
    }
}

function resetAll() {
    var products = document.querySelectorAll(".product, .product-active, .product-depleted");
    for (var i = 0; i < products.length; i ++) {
        products[i].querySelector(".qty").value = 0;
    }
    populateTable();
}

function addQtyToProduct(qty, product) {
    var input = document.querySelector("#product-" + product + " .qty");
    var val = parseInt(input.value, 10);
    val += qty;
    if (typeof val === 'undefined' || typeof val === 'string' ||
        val === null || Number.isNaN(val)) {
        val = 0;
    }
    input.value = val;
    populateTable();
}

function saveTicket() {
    var toSend = {
        commande : commande,
        client : document.querySelector("#client").value
    };
    toSend = JSON.stringify(toSend);
    console.log(toSend);
    var url = rootURL + "/commerce/vente/save/" + id_vente;
    $.ajax({
        type : "POST",
        url : url,
        data : toSend,
        contentType : "application/json; charset=utf8",
        success : function(data) {
            if (data === "OK") {
                document.location = rootURL + "/commerce/vente/";
            } else {
                alert("Erreur côté serveur !");
            }
        },
        failure : function(err) {
            alert("Impossible d'envoyer la requête au serveur pour le moment !");
        }
    });
}

window.onload = function() {
    populateTable();
};
