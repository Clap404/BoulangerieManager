var infosGraphiques = JSON.parse(document.getElementById("json_total").innerHTML);
var infosPie = JSON.parse(document.getElementById("json_invendus").innerHTML);

function drawPie(day, dayname)
{
    document.getElementById("chartdiv").innerHTML = "";
    var data = [];
    for(var i in infosPie[6 - day])
        data.push([infosPie[6 - day][i]["nom_produit"], parseInt(infosPie[6 - day][i]["quantite"])]);

    var plot1 = jQuery.jqplot ('chartdiv', [data],
    {
        title: 'Répartition des invendus de ' + dayname,
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

function drawBar()
{
    document.getElementById("chartdiv").innerHTML = "";
    var line1 = [];
    for(var i in infosGraphiques)
        line1.push([infosGraphiques[6 - i]["date_invendu"], parseInt(infosGraphiques[6 - i]["sum_quantite"])]);

    var plot1 = $.jqplot('chartdiv', [line1], {
        title: 'Évolution des invendus durant les 7 derniers jours',
        series:[{renderer:$.jqplot.BarRenderer}],
        axesDefaults: {
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
            labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
            renderer: $.jqplot.CategoryAxisRenderer,
            syncTicks: true
          },
          yaxis: {
            labelRenderer: $.jqplot.CanvasAxisLabelRenderer,
            tickOptions: {
                angle: 0,
                fontSize: '12pt',
            },
            labelOptions: {
                fontSize: '12pt'
            },
            autoscale:true
          }
        },
        highlighter: {
            show: true,
            sizeAdjust: 5.5,
            tooltipSeparator: ' : '
        },
    });
}

$(document).ready(drawBar());
