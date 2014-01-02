function back2Normal(id)
{
    if(id === "popup")
    {
        var popup_id = document.getElementById("popup_id").innerHTML;
        // Change le nom de la matière première dans la liste des matprem
        document.getElementById("name_" + popup_id).innerHTML = document.getElementById("name_popup").innerHTML;
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
    console.log(data);

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
            document.getElementById("name_" + balID).innerHTML = data["nom_matiere_premiere"];
            back2Normal(balID);
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
    $('tr:visible:even').css('background-color', csseven);
    $('tr:visible:odd').css('background-color', cssodd);
}

function switch2ModifyPopup()
{
    var name = document.getElementById("name_popup");
    document.getElementById("modif_name_input_popup").value = name.innerHTML;

    name.style.display = "none";
    document.getElementById("modif_name_input_popup").style.display = "inline";

    document.getElementById("modif_button_popup").style.display = "none";
    document.getElementById("save_button_popup").style.display = "inline";
    document.getElementById("cancel_button_popup").style.display = "inline";
}

function fillPopup(data)
{
    var popup = document.getElementById("pop_up");
    var base_url = document.getElementById("base_url").innerHTML;
    var matprem = data["matprem"];
    var fournisseur = data["fournisseur"];

    var popupContent = "<span id='popup_id' style='display: none;'>" + matprem["id_matiere_premiere"] + "</span>";
    popupContent += "<h3><span id=name_popup>" + matprem["nom_matiere_premiere"] + "</span><input id=modif_name_input_popup style='display:none;' onkeydown='if (event.keyCode == 13) document.getElementById(\"save_button_popup\").click()'></input></h3>"

    popupContent += "<span id='error_popup'></span>";

    popupContent += "<div style='float: right; margin-right: 10%;'>" +
                        "<button onclick='self.location.href=\"" + base_url + "index.php/stocks/matprem/detail/" + matprem['id_matiere_premiere'] + "\";'>Détails</button><br>" +
                        "<button id='modif_button_popup' onclick='switch2ModifyPopup();'>Modifier</button>" +
                        "<button style='display:none;' id='save_button_popup' onclick='saveModifPopup(\"" + matprem["id_matiere_premiere"] + "\");'>Sauvegarder</button>" +
                        "<button style='display:none;' id='cancel_button_popup' onclick='ajaxQuickDetails(\"" + matprem['id_matiere_premiere'] + "\");'>Annuler</button>" +
                    "</div>";

    popupContent += '<table>';
    popupContent += '<tr>' +
                            '<td colspan="2"><img src="' + base_url + 'assets/images/matprem/' + matprem["id_matiere_premiere"] + '.jpg"/></td>' +
                    '</tr>';
    popupContent += '<tr><td>' + matprem["disponibilite_matiere_premiere"] + ' ' + matprem["abbreviation_unite"] + '</td></tr>';
    popupContent += '</table>';

    popupContent += "<p><b>Prix le plus bas : </b>" + fournisseur["prix"] + "€<br/>";
    popupContent += "<b>Fourni par : </b>" + fournisseur["nom_fournisseur"] + "</p>";

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
            fillPopup(response);
        }
        else
            popup.innerHTML = stringError;
    };

    xhr.send(parameters);
}

function popupButton(id)
{
    // Fill the popup window
    ajaxQuickDetails(id);

    $(function(){
        $('#pop_up').bPopup({
            opacity: 0.6,
            positionStyle: 'fixed'
        });
    });
}

switchButtonList(document.getElementById("switchOn").checked);
