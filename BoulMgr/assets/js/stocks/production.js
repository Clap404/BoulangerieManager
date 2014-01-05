var nb_ligne = 0;

function add_line() {
    
    //récuperation de la table
    var table = document.getElementsByTagName('table')[0];

    //Création de la ligne
    var tr = document.createElement('tr');

    //Select pour les produits
    var td_prod = document.createElement('td');
    var select_produit = document.createElement('select');
    select_produit.setAttribute('name', 'prod'+nb_ligne);

    //Input text pour la quantité
    var td_qte = document.createElement('td');
    var input_qte = document.createElement('input');
    input_qte.setAttribute('type', 'text');
    input_qte.setAttribute('name', 'qte'+nb_ligne);
    
    //Nouvelle ligne
    var tr_add_line = document.querySelector('#addline');
    if(tr_add_line != null) {
        tr_add_line.parentNode.removeChild(tr_add_line);
    }
    tr_add_line = document.createElement('tr');
    tr_add_line.setAttribute('id','addline');
    var td_vide = document.createElement('td');
    var td_add = document.createElement('td');
    var span = document.createElement('span');
    span.setAttribute('onclick','add_line()');
    span.innerHTML = 'Ajouter une ligne';

    //Ajout à la page
    table.appendChild(tr);

    tr.appendChild(td_prod);
    td_prod.appendChild(select_produit);
    
    tr.appendChild(td_qte);
    td_qte.appendChild(input_qte);

    table.appendChild(tr_add_line);
    tr_add_line.appendChild(td_vide);
    tr_add_line.appendChild(td_add);
    td_add.appendChild(span);
    
    //Peuplement du select
    var url = document.location.href;
    url += '/getproduits';
    setSelectOptions(select_produit, url, 'nom_produit', 'id_produit'); 
    
    nb_ligne++;
    document.querySelector('input[name=nbligne]').value = nb_ligne;
}

function setSelectOptions(datalistToFill, requestUrl, putInValue, putInId) {
    
    var xhr = new XMLHttpRequest();

    xhr.onreadystatechange = function(oEvent)
    {
        if (xhr.readyState == 4 && xhr.status == 200){

            var responseArray = JSON.parse(xhr.responseText);

            for (var i = 0; i < responseArray.length ; i ++) {
                var newOption = document.createElement("option");
                newOption.innerHTML = responseArray[i][putInValue];
                newOption.value = responseArray[i][putInId];

                datalistToFill.appendChild(newOption);
            }
        }

    };

    xhr.open("GET", requestUrl, true);
    xhr.send();
}

add_line();

