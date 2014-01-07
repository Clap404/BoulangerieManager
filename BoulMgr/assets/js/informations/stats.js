var infos_per_year = JSON.parse(document.getElementById("json_per_year").innerHTML);
var infos_per_week = JSON.parse(document.getElementById("json_per_week").innerHTML);
var total_per_week = JSON.parse(document.getElementById("json_total_per_week").innerHTML);
var total_per_year = JSON.parse(document.getElementById("json_total_per_week").innerHTML);

function drawPie(infos, titleGraph)
{
    document.getElementById("chartdiv").innerHTML = "";
    var data = [];
    for(var i in infos)
        data.push([infos[i]["nom_produit"], parseInt(infos[i]["somme_produit"])]);

    var plot1 = jQuery.jqplot ('chartdiv', [data],
    {
        title: titleGraph,
        seriesDefaults: {
            // Make this a pie chart.
            renderer: jQuery.jqplot.PieRenderer,
            rendererOptions: {
                // Put data labels on the pie slices.
                // By default, labels show the percentage of the slice.
                showDataLabels: true
            }
        },
        legend: { show:true, location: 'e' }
    }
  );
}

$(document).ready(drawPie(infos_per_week, "Répartition des ventes cette semaine"));
