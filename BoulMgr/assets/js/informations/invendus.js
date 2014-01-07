var infosGraphiques;

function infosGraphique()
{
    var base_url = document.getElementById("base_url").innerHTML;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url + "index.php/informations/invendus/jsonTotalPerDay", false);

    var errorMessage = document.getElementById("error");
    var stringError = "Erreur lors de l'affichage des invendus";

    xhr.onreadystatechange = function (oEvent)
    {
        if (xhr.readyState == 4 && xhr.status != 200)
            errorMessage.innerHTML = stringError;
    };

    xhr.onloadend = function () {
        if (xhr.readyState == 4 && xhr.status == 200)
        {
            var response = JSON.parse(xhr.responseText);
            console.log("Response : " + response);
            infosGraphiques = response;
        }
        else
            errorMessage.innerHTML = stringError;
    };

    xhr.send();
}

function test()
{
    console.log(infosGraphiques);
}

$(document).ready(function(){
    var line1 = [];
    for(var i in infosGraphiques)
        line1.push([infosGraphiques[i]["date_invendu"], parseInt(infosGraphiques[i]["sum_quantite"])]);

    var plot1 = $.jqplot('chartdiv', [line1], {
        title: 'Évolution des invendus dans la semaine',
        series:[{renderer:$.jqplot.BarRenderer}],
        axesDefaults: {
            labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
            tickRenderer: $.jqplot.CanvasAxisTickRenderer,
            tickOptions: {
                angle: -30,
                fontSize: '12pt',
            },
            showTicks: true,
            showTicksMarks: true,
        },
        axes: {
          xaxis: {
            renderer: $.jqplot.CategoryAxisRenderer,
            syncTicks: true
          },
          yaxis: {
            autoscale:true
          }
        },
        highlighter: {
            show: true,
            sizeAdjust: 5.5,
            tooltipSeparator: ' : '
        }
    });
});

infosGraphique();
