var infos_per_year = JSON.parse(document.getElementById("json_per_year").innerHTML);
var infos_per_week = JSON.parse(document.getElementById("json_per_week").innerHTML);
var total_per_week = JSON.parse(document.getElementById("json_total_per_week").innerHTML);
var total_per_year = JSON.parse(document.getElementById("json_total_per_week").innerHTML);
var years = [];

function drawPie(infos, titleGraph)
{
    document.getElementById("chartdiv").innerHTML = "";
    var data = [];
    for(var i in infos)
        data.push([infos[i]["nom_produit"], parseFloat(infos[i]["somme_produit"])]);

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

function drawChart(infos, i)
{
    yearGraph = years[i]["year_vente"]
    var titleGraph = "Répartition des ventes de l'année " + yearGraph + " (Total " + years[i]["somme_produit"] + " €)"
    document.getElementById("chartdiv").innerHTML = "";
    var line1 = [];
    for(var j in infos)
        line1.push([infos[j]["jour_vente"], parseFloat(infos[j]["somme_produit"])]);
    var plot1 = $.jqplot('chartdiv', [line1], {
        title: titleGraph,
        axes:{
            xaxis:{
                renderer:$.jqplot.DateAxisRenderer,
                tickOptions:{
                    formatString:'%b&nbsp;%#d'
                },
                min: yearGraph + '-01-01',
                max: yearGraph + '-12-31',
                tickInterval:'1 month'
            },
        yaxis:{
            tickOptions:{
                formatString:'%.2f €'
            }
        }
        },
        highlighter: {
            show: true,
        sizeAdjust: 7.5
        },
        cursor: {
            show: false
        }
    });
}

function getYears()
{
    var base_url = document.getElementById("base_url").innerHTML;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url + "index.php/informations/stats/total_vente_per_year", true);

    xhr.onloadend = function () {
        if (xhr.readyState == 4 && xhr.status == 200)
        {
            years = JSON.parse(xhr.responseText);
            setHistMenu(years);
            getYearHistory(years.length - 1);
        }
    };

    xhr.send();
}

function getYearHistory(i)
{
    var base_url = document.getElementById("base_url").innerHTML;
    var xhr = new XMLHttpRequest();
    xhr.open("POST", base_url + "index.php/informations/stats/history/" + years[i]["year_vente"], true);

    xhr.onloadend = function () {
        if (xhr.readyState == 4 && xhr.status == 200)
        {
            var history = JSON.parse(xhr.responseText);
            drawChart(history, i);
        }

    };

    xhr.send();
}

function setHistMenu(years)
{
    var menuHTML = "<tr>";
    for(i in years)
    {
        if((i % 5) == 0)
        {
            menuHTML += "</tr><tr>";
        }


        menuHTML += '<th><a href="#" onclick="getYearHistory('+ i +');">' + years[i]["year_vente"] + '</a></th>';
        console.log(menuHTML);
    }
    menuHTML += "</tr>";
    document.getElementById("menu").innerHTML = menuHTML;
}

function switch2Hist()
{
    getYears();
}

function switch2Repart()
{
    var menuHTML = "<tr>" +
                        '<th><a href="#" onclick="drawPie(infos_per_week, \'Répartition des ventes ces 7 derniers jours\');">Depuis une semaine</a></th>' +
                        '<th><a href="#" onclick="drawPie(infos_per_year, \'Répartition des ventes cette année\');">Année courante</a></th>' +
                   "</tr>";
    document.getElementById("menu").innerHTML = menuHTML;
    drawPie(infos_per_week, "Répartition des ventes cette semaine");
}


$(document).ready(switch2Repart());
