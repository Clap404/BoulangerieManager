var infosGraphiques = JSON.parse(document.getElementById("json_total").innerHTML);

$(document).ready(function(){
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
});
