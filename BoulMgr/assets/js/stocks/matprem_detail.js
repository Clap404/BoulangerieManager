function sendCommand(data, errorMessage)
{
    document.getElementById("save_command").disabled = true;
    var base_url = document.getElementById("base_url").innerHTML;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url + "index.php/stocks/matprem/addCommand", true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
    console.log(data);

    var stringError = "Erreur lors de l'enregistrement de la commande";

    xhr.onreadystatechange = function (oEvent)
    {
        if (xhr.readyState == 4 && xhr.status != 200)
            errorMessage.innerHTML = stringError;
    };

    xhr.onloadend = function () {
        document.getElementById("save_command").disabled = false;

        if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText == 1)
        {
            $(function(){
                $('#pop_up').bPopup().close();
            });
            location.reload();
        }
        else
            errorMessage.innerHTML = stringError;
    };

    xhr.send(JSON.stringify(data));
}

function saveCommand(id_fourn)
{
    var data = {};
    data["quantite_matiere_premiere"] = document.getElementById("qte_command").value;
    data["id_matiere_premiere"] = document.getElementById("idMatprem").innerHTML;
    data["id_fournisseur"] = id_fourn;

    var errorMessage = document.getElementById("error_command");
    sendCommand(data,errorMessage);
}

function checkSaveModif()
{
    var button = document.getElementById("save_command");
    var qte = document.getElementById("qte_command");

    var check = parseFloat(qte.value) <= 0 || isNaN(parseFloat(qte.value));
    button.disabled = check;
    return !check;
}

function refreshTotalPrice()
{
    var totalPrice = document.getElementById("prix_total_command");
    var price = document.getElementById("prix_command");
    var qte = document.getElementById("qte_command");


    totalPrice.innerHTML = parseFloat(price.innerHTML) * parseFloat(qte.value) || 0;
    totalPrice.innerHTML = parseFloat(totalPrice.innerHTML).toFixed(2);
    totalPrice.innerHTML += "€";
    checkSaveModif();
}

function fillPopup(id_fourn)
{
    var popup = document.getElementById("pop_up");
    popup.innerHTML = "";
    var html_fournisseur = document.getElementById("nom_fourn_" + id_fourn).innerHTML;
    var html_prix = document.getElementById("prix_fourn_" + id_fourn).innerHTML;
    var b;

    var title = document.createElement("h3");
    title.appendChild(document.createTextNode("Commander"));
    popup.appendChild(title);

    var error = document.createElement("span");
    error.id = "error_command";
    popup.appendChild(error);

    var div = document.createElement("div");

    var fournisseur = document.createElement("span");
    fournisseur.id = "fournisseur_command";
    b = document.createElement("b");
    b.appendChild(document.createTextNode("Fournisseur : "));
    fournisseur.appendChild(b);
    fournisseur.appendChild(document.createTextNode(html_fournisseur));
    fournisseur.appendChild(document.createElement("br"));
    div.appendChild(fournisseur);

    var prix = document.createElement("b");
    prix.appendChild(document.createTextNode("Prix unitaire : "));
    div.appendChild(prix);
    var prix_result = document.createElement("span");
    prix_result.appendChild(document.createTextNode(html_prix));
    prix_result.id = "prix_command";
    div.appendChild(prix_result);
    div.appendChild(document.createTextNode("€"));
    div.appendChild(document.createElement("br"));

    var qte = document.createElement("b");
    qte.appendChild(document.createTextNode("Quantité (en " + document.getElementById("abrev_unite").innerHTML + ") : "));
    div.appendChild(qte);
    var qte_input = document.createElement("input");
    qte_input.id = "qte_command";
    qte_input.onkeydown = function(event){
        if (event.keyCode == 13)
            document.getElementById("save_command").click();
    }
    qte_input.onkeyup = function(){refreshTotalPrice();};
    div.appendChild(qte_input);
    div.appendChild(document.createElement("br"));

    prix_total = document.createElement("b");
    prix_total.appendChild(document.createTextNode("Prix total : "));
    div.appendChild(prix_total);
    var prix_total_result = document.createElement("span");
    prix_total_result.id = "prix_total_command";
    prix_total_result.appendChild(document.createTextNode("0.00€"));
    div.appendChild(prix_total_result);

    popup.appendChild(div);

    div = document.createElement("div");
    var valider = document.createElement("button");
    valider.id = "save_command";
    valider.onclick = function(){checkSaveModif() && saveCommand(id_fourn);};
    valider.appendChild(document.createTextNode("Valider"));
    valider.disabled = true;
    div.appendChild(valider);
    popup.appendChild(div);
}

function popupButton(id_fourn)
{
    // Fill the popup window
    fillPopup(id_fourn);

    $(function(){
        $('#pop_up').bPopup({
            opacity: 0.6,
            positionStyle: 'fixed'
        });
    });
    document.getElementById("qte_command").focus();
}
