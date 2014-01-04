/*
include :
    <script defer src="<?= base_url("/assets/js/bpopup.min.js") ?>"></script>
    <script defer src="<?= base_url("/assets/js/stocks/matprem.js") ?>"></script>
somewhere in the page where it will be used

This script make a popup which contains the page located at <url>
requestMethod must be set at GET or POST,
closeButtonSelector does nothing (for now)
opacity must be between 0 and 1
positionStyle can be fixed or another value as described here : http://dinbror.dk/bpopup/

*/

function popupFormAjax(url, requestMethod, closeButtonSelector, opacity, positionStyle) {
    var popup = document.createElement("div");
    popup.setAttribute("id", "pop_up")

    //TODO, un CSS pour les popups avec l'id "pop_up" pour fonctionner avec la lib anthony 
    popup.style="display: none; width: 600px; height: 400px; padding: 20px; background-color: white;";

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function (oEvent)
    {
        if (xhr.readyState == 4 && xhr.status != 200)
            popup.innerHTML = xhr.stringError;
        else
            popup.innerHTML = "Chargement en cours...";
    };

    xhr.onloadend = function () {
        popup.innerHTML = xhr.responseText;
        //run scripts in the popup
        eval(popup.querySelector("script").innerHTML);
    };

    xhr.open(requestMethod, url, true);
    xhr.send();

    $(popup).bPopup({
        opacity: opacity,
        positionStyle: positionStyle
    });
}

/*
This script opens a div already present in the page in a bPopup.
popupSelector identifies the div to pop
closeButtonSelector identifies a button inside the popup that closes it (not implemented)
opacity and positionStyle should be set according to bpopup doc or left undefined
*/

function popupFormDiv(popupSelector, closeButtonSelector, opacity, positionStyle) {
    var popup = document.querySelector(popupSelector);

    //TODO, un CSS pour les popups avec l'id "pop_up" pour fonctionner avec la lib anthony 
    popup.style="display: none; width: 640px; padding: 20px; background-color: white;";

    $(popup).bPopup({
        opacity: opacity,
        positionStyle: positionStyle
    });
}

/*
    Permet de remplir les options d'une datalist à partir d'un array d'objets JSON
    datalistTofill est le node de la datalist à peupler
    requestUrl est l'URL vers laquelle doit être faite la requête
    putInId et putInValue sont respectivement les noms des attributs dans les objets JSON
        à placer dans id et value des <option>

    Cette fonction efface toutes les options de la datalist à chaque appel avant de repeupler.

    Cette fonction peut être utilisé avec la callback oninput
*/

var setDatalistOptions = function(datalistToFill, requestUrl, putInValue) {

    //remove already present option nodes
    while( datalistToFill.hasChildNodes() ){
        datalistToFill.removeChild(datalistToFill.lastChild);
    }

    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function(oEvent)
    {
        if (xhr.readyState == 4 && xhr.status == 200){

            var responseArray = JSON.parse(xhr.responseText);

            for (var i = 0; i < responseArray.length ; i ++) {
                var newOption = document.createElement("option");
                newOption.value = responseArray[i][putInValue];

                datalistToFill.appendChild(newOption);
            };
        }

    };

    xhr.open("GET", requestUrl, true);
    xhr.send();

}

var setInputValue = function(inputTofill, requestUrl, putInValue) {
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function(oEvent)
    {
        if (xhr.readyState == 4 && xhr.status == 200){
            var responseArray = JSON.parse(xhr.responseText);
            inputTofill.value = responseArray[0][putInValue];
        }

    };

    xhr.open("GET", requestUrl, true);
    xhr.send();
}

var firstCharChanged = function(input) {
    if(typeof(input.last1stChar) == "undefined" ) { input.last1stChar = null}

    if(input.value.length === 1 && input.last1stChar !== input.value) {
        input.last1stChar = input.value;
        return true;
    }

    return false;
}