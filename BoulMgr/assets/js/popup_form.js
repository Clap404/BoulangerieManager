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
