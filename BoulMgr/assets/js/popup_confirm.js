function fillConfirmationPopup(id_popup, title, functionYes, functionNo)
{
    var popup = document.getElementById(id_popup);

    var popupContent = "<h3>" + title + "</h3>"

    popupContent += "<span id='error_confirmation_popup'></span><br>";

    popupContent += "<div>" +
                        "<button id='yes_button_popup'>Oui</button> " +
                        "<button id='no_button_popup'>Non</button>" +
                    "</div>";

    popup.innerHTML = popupContent;

    document.getElementById("yes_button_popup").onclick = function()
    {
        document.getElementById("yes_button_popup").disabled = true;
        var ok = functionYes();
        if(ok)
            closePopup(id_popup);
        document.getElementById("yes_button_popup").disabled = false;
    }

    document.getElementById("no_button_popup").onclick = function()
    {
        document.getElementById("yes_button_popup").disabled = true;

        if(typeof functionNo != "undefined")
            var ok = functionNo();
        else
            var ok = true;

        if(ok)
            closePopup(id_popup);
        document.getElementById("yes_button_popup").disabled = false;
    }
}

function closePopup(id_popup)
{
    $(function(){
        $('#' + id_popup).bPopup().close();
    });
}

/**
 * Show a popup to ask confirmation at the user
 * @param {string} id_popup : id of the div_popup to show
 * @param {string} popup_title : Popup title (question asked to the user)
 * @param {function} functionYes : Function launched when it's yes
 * @param {function} functionNo : Function launched when it's no
 *
 * functionYes and functionNo has to return true if everything is ok, false if
 * there is an error. The error can be printed in the element
 * #error_confirmation_popup
 */
function popupConfirmation(id_popup, popup_title, functionYes, functionNo)
{
    if(typeof popup_title === "undefined")
        popup_title = "Confirmer ?";

    fillConfirmationPopup(id_popup, popup_title, functionYes, functionNo);
    $(function(){
        $('#' + id_popup).bPopup({
            opacity: 0.6,
            positionStyle: 'fixed'
        });
    });
}
