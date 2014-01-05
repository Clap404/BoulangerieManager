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
    } else if (val >= 999) {
        //999 super arbitraire
        val = 999;
    }
    input.value = val;
    checkIfNewActive();
}

function checkDate(date) {
    if (date.match(/^[0-9]{4}-[0-9]{2}-[0-9]{2} [0-9]{2}:[0-9]{2}:[0-9]{2}$/) !== null) {
        return true;
    }
    alert("La date saisie n'est pas valide !");
    return false;
}

function checkClient(client) {
    if (client !== null && client !== "null" && parseInt(client).toString() === client) {
        return true;
    }
    alert("Le client saisi n'est pas valide !");
    return false;
} 

function checkAdresse(adresse) {
    if (adresse !== null && adresse !== "null" && parseInt(adresse).toString() === adresse) {
        return true;
    }
    alert("L'adresse choisie n'est pas valide !");
    return false;
}


function saveTicket() {
    //manipulation de la date
    var datetime = document.querySelector("#datepicker").value.split(" ");
    var date = datetime[0].split("/").reverse().join("-");
    var datetime = date + " " + datetime[1] + ":00";
    var client = document.querySelector("#client").value;
    var adresse = document.querySelector("#adresse").value;
    
    //validation
    var ok = true;
    ok &= checkDate(datetime);
    ok &= checkClient(client);
    ok &= checkAdresse(adresse);
    if (!ok) {
        return;
    }

    var toSend = {
        commande : commande,
        client : client,
        adresse : adresse,
        date : datetime
    };
    toSend = JSON.stringify(toSend);
    console.log(toSend);
    var url = rootURL + "/commerce/commande/save/" + id_commande;
    $.ajax({
        type : "POST",
        url : url,
        data : toSend,
        contentType : "application/json; charset=utf8",
        success : function(data) {
            if (data === "OK") {
                document.location = rootURL + "/commerce/commande/";
            } else {
                alert("Erreur côté serveur !");
                console.log(data);
            }
        },
        failure : function(err) {
            alert("Impossible d'envoyer la requête au serveur pour le moment !");
        }
    });
}

window.onload = function() {
    populateTable();
    $("#datepicker").datetimepicker({
        lang:'fr',
        i18n:{
            fr:{
                months:[
                'Janvier','Fevrier','Mars','Avril',
                'Mai','Juin','Juillet','Août',
                'Septembre','Octobre','Novembre','Decembre',
                ],
                dayOfWeek:[
                "Di", "Lu", "Ma", "Me", 
                "Je", "Ve", "Sa",
                ]
            }
        },
        minDate:0,
        minTime:'6:00',
        maxTime:'19:00',
        mask:true,
        timepicker:true,
        format:'d/m/Y H:i',
        dayOfWeekStart: 1
    });
};

function updateAdresses(toSelect) {
    toSelect = toSelect || -1; 
    var client = document.querySelector("#client").value;
    var url = rootURL + "/commerce/commande/getadresse/" + client;
    $.ajax({
        type : "GET",
        url : url,
        success : function(data) {
            var adresses = JSON.parse(data);
            var select = document.querySelector("#adresse");
            select.innerHTML = "";
            for (var i = 0; i < adresses.length; i += 1) {
                var opt = document.createElement("option");
                opt.value = adresses[i]["id_adresse"];

                if (parseInt(opt, 10) === toSelect) {
                    opt.selected = true;
                }
                opt.innerHTML = adresses[i]["numero_voie_adresse"] + ", " +
                                adresses[i]["nom_type_voie"] + " " +
                                adresses[i]["nom_voie_adresse"] + " (" +
                                adresses[i]["code_postal"] + ", " +
                                adresses[i]["nom_ville"] + ")";
                select.appendChild(opt);
            }
        },
        failure : function(err) {
            alert("Erreur côté serveur !");
            console.log(err)
        }
    });
}

