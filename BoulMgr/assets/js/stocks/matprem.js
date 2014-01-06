function back2Normal(id)
{
    if(id === "popup")
    {
        var popup_id = document.getElementById("popup_id").innerHTML;
        // Change le nom de la matière première dans la liste des matprem
        document.getElementById("name_" + popup_id).innerHTML = document.getElementById("name_popup").innerHTML;
        document.getElementById("details_button_popup").style.display = "inline";
        document.getElementById("commander_button_popup").style.display = "inline";
        document.getElementById("div_command").style.display = "none";
        document.getElementById("image_preview").style.display = "none";
        var image_popup = document.getElementById("image_popup");
        image_popup.style.display = "inline";
        ajaxQuickDetails(popup_id);
        return;
    }

    document.getElementById("name_" + id).style.display = "inline";
    document.getElementById("modif_name_input_" + id).style.display = "none";

    document.getElementById("modif_button_" + id).style.display = "inline";
    document.getElementById("save_button_" + id).style.display = "none";
    document.getElementById("cancel_button_" + id).style.display = "none";
    document.getElementById("error").innerHTML = "";
}

function switch2Modify(id)
{
    // TODO Permettre le changement d'image dans le popup
    var name = document.getElementById("name_" + id).innerHTML;
    document.getElementById("modif_name_input_" + id).value = name;

    document.getElementById("name_" + id).style.display = "none";
    document.getElementById("modif_name_input_" + id).style.display = "inline";

    document.getElementById("modif_button_" + id).style.display = "none";
    document.getElementById("save_button_" + id).style.display = "inline";
    document.getElementById("cancel_button_" + id).style.display = "inline";
}

function saveModif(id)
{
    var data = {};
    data["id_matiere_premiere"] = id;
    data["nom_matiere_premiere"] = document.getElementById("modif_name_input_" + id).value;

    var errorMessage = document.getElementById("error");
    sendModif(data, errorMessage, id);
}

function saveModifPopup(id)
{
    var data = {};
    data["id_matiere_premiere"] = id;
    data["nom_matiere_premiere"] = document.getElementById("modif_name_input_popup").value;

    var errorMessage = document.getElementById("error_popup");
    sendModif(data, errorMessage, "popup");
}

function saveAddMatprem()
{
    if(!checkSaveAddMatprem)
        return;

    var data = {};
    data["nom_matiere_premiere"] = document.getElementById("nom_add_matiere_premiere").value;
    data["abbreviation_unite"] = document.getElementById("unite_input").value;
    var errorMessage = document.getElementById("error_popup");
    sendAddMatprem(data, errorMessage);
}

function saveCommand(id_fourn)
{
    var data = {};
    data["quantite_matiere_premiere"] = document.getElementById("qte_command").value;
    data["id_matiere_premiere"] = document.getElementById("popup_id").innerHTML;
    data["id_fournisseur"] = id_fourn;

    var errorMessage = document.getElementById("error_popup");
    sendCommand(data,errorMessage);
}

function getListUnites()
{
    var base_url = document.getElementById("base_url").innerHTML;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url + "index.php/stocks/matprem/jsonListUnites", true);

    xhr.onloadend = function () {
        if (xhr.readyState == 4 && xhr.status == 200)
            listUnites(xhr.responseText);
    };

    xhr.send();
}

function sendAddMatprem(data, errorMessage)
{
    document.getElementById("save_button_popup").disabled = true;
    var base_url = document.getElementById("base_url").innerHTML;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url + "index.php/stocks/matprem/addMatPrem", true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');

    var stringError = "Erreur lors de l'ajout";

    xhr.onreadystatechange = function (oEvent)
    {
        if (xhr.readyState == 4 && xhr.status != 200)
            errorMessage.innerHTML = stringError;
    };

    xhr.onloadend = function () {
        document.getElementById("save_button_popup").disabled = false;

        console.log("Response : " + xhr.responseText);
        if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText > 0)
        {
            console.log("Response : " + xhr.responseText);
            sendImageMatprem(xhr.responseText, errorMessage);
            $(function(){
                $('#pop_up').bPopup().close();
            });
            location.reload();
        }
        else if (xhr.readyState === 4 && xhr.status === 200 && xhr.responseText == -1)
            errorMessage.innerHTML = "Erreur, le nom de la matière première existe déjà.";
        else
            errorMessage.innerHTML = stringError;
    };

    xhr.send(JSON.stringify(data));
}

function sendImageMatprem(id_matprem, errorMessage)
{
    var fileInput = document.querySelector('#upload_image');
    if(typeof fileInput.files[0] === "undefined")
        return;

    document.getElementById("save_button_popup").disabled = true;
    var base_url = document.getElementById("base_url").innerHTML;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url + "index.php/stocks/matprem/uploadMatpremImage/" + id_matprem, false);

    var stringError = "Erreur lors de l'ajout";

    xhr.onreadystatechange = function (oEvent)
    {
        if (xhr.readyState == 4 && xhr.status != 200)
            errorMessage.innerHTML = stringError;
    };

    xhr.onloadend = function () {
        document.getElementById("save_button_popup").disabled = false;

        console.log("Response : " + xhr.responseText);
        if (xhr.readyState == 4 && xhr.status == 200)
        {
            console.log("Response : " + xhr.responseText);
            location.reload();
        }
    };

    var form = new FormData();
    form.append('upload_image', fileInput.files[0]);
    xhr.send(form);
}

/**
 * Send modifications to the server (using AJAX)
 * @param {array} data : contains all the data about the matprem
 * @param {HTML element} errorMessage : send document.getElementById/Name("error_id") to print an error
 * @param {number} balID : Maptrem id, or send "popup" if it's a modification in the popup
 */

function sendModif(data, errorMessage, balID)
{
    document.getElementById("save_button_" + balID).disabled = true;
    var base_url = document.getElementById("base_url").innerHTML;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url + "index.php/stocks/matprem/modify", true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');

    var stringError = "Erreur lors de la modification";

    xhr.onreadystatechange = function (oEvent)
    {
        if (xhr.readyState == 4 && xhr.status != 200)
            errorMessage.innerHTML = stringError;
    };

    xhr.onloadend = function () {
        document.getElementById("save_button_" + balID).disabled = false;

        if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText == 1)
        {
            console.log("Response : " + xhr.responseText);

            if(balID === "popup")
            {
                var idMatprem = document.getElementById("popup_id").innerHTML;
                sendImageMatprem(idMatprem, errorMessage);
            }
            document.getElementById("name_" + balID).innerHTML = data["nom_matiere_premiere"];
            back2Normal(balID);
        }
        else
            errorMessage.innerHTML = stringError;
    };

    xhr.send(JSON.stringify(data));
}

function sendCommand(data, errorMessage)
{
    document.getElementById("save_button_popup").disabled = true;
    var base_url = document.getElementById("base_url").innerHTML;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url + "index.php/stocks/matprem/addCommand", true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');

    var stringError = "Erreur lors de l'enregistrement de la commande";

    xhr.onreadystatechange = function (oEvent)
    {
        if (xhr.readyState == 4 && xhr.status != 200)
            errorMessage.innerHTML = stringError;
    };

    xhr.onloadend = function () {
        document.getElementById("save_button_popup").disabled = false;

        if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText == 1)
        {
            console.log("Response : " + xhr.responseText);
            $(function(){
                $('#pop_up').bPopup().close();
            });
            // Refresh the page to force the modified image to reload
            location.reload();
        }
        else
            errorMessage.innerHTML = stringError;
    };

    xhr.send(JSON.stringify(data));
}

function switchButtonList(buttonState)
{
    var prop = "none";
    csseven = $('tr:even').css('background-color');
    cssodd = $('tr:odd').css('background-color');

    if(buttonState)
        prop = "table-row";
    else
        prop = "none";

    $('.matpremHiddenItem').css('display', prop);
    $('.matpremHiddenItem undispo').css('display', prop);
    $('tr:visible:even').css('background-color', csseven);
    $('tr:visible:odd').css('background-color', cssodd);
}

function switch2ModifyPopup()
{
    var name = document.getElementById("name_popup");
    document.getElementById("modif_name_input_popup").value = name.innerHTML;

    name.style.display = "none";
    document.getElementById("modif_name_input_popup").style.display = "inline";

    document.getElementById("details_button_popup").style.display = "none";
    document.getElementById("commander_button_popup").style.display = "none";
    document.getElementById("modif_button_popup").style.display = "none";

    var id_matprem = document.getElementById("popup_id").innerHTML;
    var save_button = document.getElementById("save_button_popup");
    save_button.onclick = function(){saveModifPopup(id_matprem);};
    save_button.style.display = "inline";
    document.getElementById("cancel_button_popup").style.display = "inline";

    var image_preview = document.getElementById("image_preview");
    image_preview.onclick = function(){document.getElementById("upload_image").click();};
    $("#upload_image").change(function(){
        readUploadFileURL(this);
    });
    image_preview.style.display = "inline";
    document.getElementById("image_popup").style.display = "none";
}

function switch2Command(id_fournisseur)
{
    document.getElementById("details_button_popup").style.display = "none";
    document.getElementById("commander_button_popup").style.display = "none";
    document.getElementById("modif_button_popup").style.display = "none";

    document.getElementById("div_command").style.display = "inline";
    var save_button = document.getElementById("save_button_popup");
    save_button.onclick = function(){saveCommand(id_fournisseur);};
    save_button.style.display = "inline";
    save_button.disabled = true;
    document.getElementById("cancel_button_popup").style.display = "inline";

    var qte_input = document.getElementById("qte_command");
    qte_input.onkeydown = function(event){
        if (event.keyCode == 13)
            document.getElementById("save_button_popup").click();
    }
    qte_input.onkeyup = function(){refreshTotalPrice();};
    document.getElementById("qte_command").focus();
}

function checkSaveModif()
{
    var button = document.getElementById("save_button_popup");
    var qte = document.getElementById("qte_command");

    var check = parseFloat(qte.value) <= 0 || isNaN(parseFloat(qte.value));
    button.disabled = check;
    return !check;
}

function checkSaveAddMatprem()
{
    var button = document.getElementById("save_button_popup");
    var name = document.getElementById("nom_add_matiere_premiere");
    var unite = document.getElementById("unite_input");

    var check = ($.trim(name.value).length && isNaN(parseInt(name.value)));
    var check = check && ($.trim(unite.value).length && isNaN(parseInt(unite.value)));
    button.disabled = !check;
    return check;
}

function checkImageExists(image_name)
{
    var http = new XMLHttpRequest();
    http.open('HEAD', image_name, false);
    http.send();
    return http.status!=404;
}

function refreshTotalPrice()
{
    var totalPrice = document.getElementById("prix_total_command");
    var price = document.getElementById("prix_min");
    var qte = document.getElementById("qte_command");

    totalPrice.innerHTML = parseFloat(price.innerHTML) * parseFloat(qte.value) || 0;
    totalPrice.innerHTML = parseFloat(totalPrice.innerHTML).toFixed(2);
    totalPrice.innerHTML += "€";
    checkSaveModif();
}

function listUnites(list_unites_json)
{
    console.log(list_unites_json);
    var list_unites = JSON.parse(list_unites_json);

    if(list_unites === [])
        return;

    var html_list_unites = document.createElement("datalist");
    html_list_unites.id="list_unite";
    var option;

    for(i in list_unites)
    {
        option = document.createElement("option");
        option.value = list_unites[i]["abbreviation_unite"];
        html_list_unites.appendChild(option);
    }

    document.getElementById("pop_up").appendChild(html_list_unites);
}

function fillPopupDetails(data)
{
    var popup = document.getElementById("pop_up");
    var base_url = document.getElementById("base_url").innerHTML;
    var en_vente = (typeof data["fournisseur"] != "undefined");
    var matprem = data["matprem"];
    if(en_vente)
        var fournisseur = data["fournisseur"];

    var popupContent = "<span id='popup_id' style='display: none;'>" + matprem["id_matiere_premiere"] + "</span>";
    popupContent += "<h3><span id=name_popup>" + matprem["nom_matiere_premiere"] + "</span><input id=modif_name_input_popup style='display:none;' onkeydown='if (event.keyCode == 13) document.getElementById(\"save_button_popup\").click()'></input></h3>"

    popupContent += "<span id='error_popup'></span>";

    popupContent += "<div style='float: right; margin-right: 10%;'>" +
                        "<button id='details_button_popup' onclick='self.location.href=\"" + base_url + "index.php/stocks/matprem/detail/" + matprem['id_matiere_premiere'] + "\";'>Détails</button> ";
    if(en_vente)
        popupContent += "<button id='commander_button_popup' title='Commander au fournisseur le moins cher' onclick='switch2Command(\"" + fournisseur['id_fournisseur'] + "\")'>Commander</button><br> ";
    popupContent +=     "<button id='modif_button_popup' onclick='switch2ModifyPopup();'>Modifier</button>" +
                        "<button style='display:none;' id='save_button_popup'>Sauvegarder</button> " +
                        "<button style='display:none;' id='cancel_button_popup' onclick='ajaxQuickDetails(\"" + matprem['id_matiere_premiere'] + "\");'>Annuler</button>" +
                    "</div>";

    if(checkImageExists(base_url + 'assets/images/matprem/' + matprem["id_matiere_premiere"] + '.jpg'))
        var image_addr = base_url + 'assets/images/matprem/' + matprem["id_matiere_premiere"] + '.jpg';
    else
        var image_addr = base_url + 'assets/images/empty.jpg';

    popupContent += "<input type='file' name='upload_image' id='upload_image' size='100' style='display:none;'/>";
    popupContent += '<table>';
    popupContent += '<tr>' +
                            '<td colspan="2"><img id="image_popup" src="' + image_addr + '"/>' +
                            '<img id="image_preview" src="' + image_addr + '" style="width: 128px; height: 128px; display: none;"/></td>' +
                    '</tr>';
    popupContent += '<tr><td>' + matprem["disponibilite_matiere_premiere"] + ' ' + matprem["abbreviation_unite"] + '</td></tr>';
    popupContent += '</table>';

    if(en_vente)
    {
        popupContent += "<p><b>Prix le plus bas : </b><span id='prix_min'>" + fournisseur["prix"] + "</span>€/" + matprem["abbreviation_unite"] + "<br/>";
        popupContent += "<b>Fourni par : </b>" + fournisseur["nom_fournisseur"] + "</p>";

        popupContent += "<div id='div_command' style='display: none;'>" +
                            "<b>Quantité à commander (en " + matprem["abbreviation_unite"] + ") : </b><input id='qte_command'></input><br>" +
                            "<b>Prix total : </b><span id='prix_total_command'>0.00€</span>" +
                        "</div>";
    }

    popup.innerHTML = popupContent;
}

function fillPopupAdd()
{
    var popup = document.getElementById("pop_up");
    var base_url = document.getElementById("base_url").innerHTML;

    var popupContent = "<h3>Ajout d'une matière première</h3>"

    popupContent += "<span id='error_popup'></span><br>";

    // TODO CSS : Mettre l'input plus long, et mettre la police plus grosse
    popupContent += "<input id='nom_add_matiere_premiere' placeholder='Nom de la matière première'>";
    popupContent += "<input type='file' name='upload_image' id='upload_image' size='100' style='display:none;'/>";
    popupContent += '<table>';
    popupContent += '<tr>' +
                            '<td colspan="2"><img id="image_preview" src="' + base_url + 'assets/images/empty.jpg" style="width: 128px; height: 128px;"/></td>' +
                    '</tr>';
    popupContent += '</table>';

    popupContent += "<b>Unité : </b><input list='list_unite' type='text' id='unite_input'>"

    popupContent += "<div>" +
                        "<button disabled onclick='saveAddMatprem();' id='save_button_popup'>Ajouter</button> " +
                        "<button id='cancel_button_popup' onclick='closePopup();'>Annuler</button>" +
                    "</div>";

    popup.innerHTML = popupContent;
}

function ajaxQuickDetails(id)
{
    var base_url = document.getElementById("base_url").innerHTML;

    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url + "index.php/stocks/matprem/jsonQuickDetail", true);
    xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    var parameters = "id=" + id;

    var popup = document.getElementById("pop_up");
    popup.innerHTML = "Chargement en cours...";
    var stringError = "Erreur lors de l'affichage du récapitulatif";

    xhr.onreadystatechange = function (oEvent)
    {
        if (xhr.readyState == 4 && xhr.status != 200)
            popup.innerHTML = stringError;
        else
            popup.innerHTML = "Chargement en cours...";
    };

    xhr.onloadend = function () {
        if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText != 0)
        {
            var response = JSON.parse(xhr.responseText);
            fillPopupDetails(response);
        }
        else
            popup.innerHTML = stringError;
    };

    xhr.send(parameters);
}

function popupDetailsButton(id)
{
    // Fill the popup window
    ajaxQuickDetails(id);
    popup();
}

/**
 * Gives the temporary URL for an image preview before the upload
 */
function readUploadFileURL(input) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            $('#image_preview').attr('src', e.target.result);
        }

        reader.readAsDataURL(input.files[0]);
    }
}

function popupAddButton()
{
    fillPopupAdd();

    getListUnites();
    var name = document.getElementById("nom_add_matiere_premiere");
    var unite = document.getElementById("unite_input");
    var onkeydownFunc = function(event){
        if (event.keyCode == 13)
            document.getElementById("save_button_popup").click();
    }
    var oninputFunc = function(){checkSaveAddMatprem();};

    name.onkeydown = onkeydownFunc;
    unite.onkeydown = onkeydownFunc;

    name.oninput = oninputFunc;
    unite.oninput = oninputFunc;

    document.getElementById("image_preview").onclick = function(){document.getElementById("upload_image").click();};
    $("#upload_image").change(function(){
        readUploadFileURL(this);
    });

    popup();
}

function popup()
{
    $(function(){
        $('#pop_up').bPopup({
            opacity: 0.6,
            positionStyle: 'fixed'
        });
    });
}

function closePopup()
{
    $(function(){
        $('#pop_up').bPopup().close();
    });
}

switchButtonList(document.getElementById("switchOn").checked);
