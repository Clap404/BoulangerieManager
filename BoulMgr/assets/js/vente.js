var commande = [];

function populateTable() {
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

function checkIfNewActive() {
    var products = document.querySelectorAll(".product, .product-active");
    for (var i = 0; i < products.length; i ++) {
        var val = products[i].children[5].value;
        if (val !== parseInt(val, 10).toString()) {
            products[i].children[5].value = 0;
            products[i].className = "product";
        } else if (val === "0") {
            products[i].className = "product";
        } else {
            products[i].className = "product-active";
        }
    }
    populateTable();
}

function resetAll() {
    var products = document.querySelectorAll(".product, .product-active");
    for (var i = 0; i < products.length; i ++) {
        products[i].querySelector(".qty").value = 0;
    }
    checkIfNewActive();
}

function addQtyToProduct(qty, product) {
    var input = document.querySelector("#product-" + product + " .qty");
    var val = parseInt(input.value, 10);
    if (typeof val === 'undefined' || typeof val === 'string' ||
        val === null || Number.isNaN(val)) {
        val = 0;
    }
    val += qty;
    if (val < 0) {
        val = 0;
    } else if (val >= 99) { //99 super arbitraire
        val = 99;
    }
    input.value = val;
    checkIfNewActive();
}

function saveTicket() {
    var toSend = JSON.stringify(commande);
    var url = rootURL + "/commerce/vente/save/" + id_vente;
    console.log("sending", toSend);
    $.ajax({
        type : "POST",
        url : url,
        data : toSend,
        contentType : "application/json; charset=utf8",
        success : function(data) {
            if (data === "1" || data === 1) {
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