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

    if(buttonState === "on")
        prop = "table-row";
    else if(buttonState === "off")
        prop = "none";
    else
        return;

    $('.matpremHiddenItem').css('display', prop);
    $('tr:visible:even').css('background-color', csseven);
    $('tr:visible:odd').css('background-color', cssodd);
}

switchButtonList("off");
