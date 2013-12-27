function back2Normal(id)
{
    document.getElementById("name_" + id).style.display = "inline";
    document.getElementById("modif_name_input_" + id).style.display = "none";

    document.getElementById("modif_button_" + id).style.display = "inline";
    document.getElementById("save_button_" + id).style.display = "none";
    document.getElementById("cancel_button_" + id).style.display = "none";
}

function switch2Modify(id)
{
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
    document.getElementById("save_button_" + id).disabled = true;
    var base_url = document.getElementById("base_url").innerHTML;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url + "index.php/stocks/matprem/modify", true);
    xhr.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');

    var data = {};
    data["id_matiere_premiere"] = id;
    data["nom_matiere_premiere"] = document.getElementById("modif_name_input_" + id).value;

    var errorMessage = document.getElementById("error");
    var stringError = "Erreur lors de la modification";

    xhr.onreadystatechange = function (oEvent)
    {
        if (xhr.readyState == 4 && xhr.status != 200)
            errorMessage.innerHTML = stringError;
    };

    xhr.onloadend = function () {
        if (xhr.readyState == 4 && xhr.status == 200 && xhr.responseText == 1)
        {
            document.getElementById("name_" + id).innerHTML = data["nom_matiere_premiere"];
            back2Normal(id);
        }
        else
            errorMessage.innerHTML = stringError;

        document.getElementById("save_button_" + id).disabled = false;
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

function fillPopup(data)
{
    var popup = document.getElementById("pop_up");
    var base_url = document.getElementById("base_url").innerHTML;
    var matprem = data["matprem"];
    var fournisseur = data["fournisseur"];

    var popupContent = "<h3>" + matprem["nom_matiere_premiere"] + "</h3>"

    popupContent += "<div style='float: right; margin-right: 10%;'><button onclick='self.location.href=\"" + base_url + "index.php/stocks/matprem/detail/" + matprem['id_matiere_premiere'] + "\";'>Détails</button></div>";

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
            var response = eval("(" + xhr.responseText + ")");
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
