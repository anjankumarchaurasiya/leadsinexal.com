"use strict";

var registered = '['+$("#registered").val()+']';
var array = $("#registered").val().split(',').map(Number).filter(x => !isNaN(x));
Highcharts.chart('container', {
    chart: {
        type: 'column'
    },
    credits: {
      enabled: false
   },
   // exporting: { enabled: false },
    title: {
        text: 'Weekly added user Graph'
    },
    
    xAxis: {
        categories: [
            'Sun',
            'Mon',
            'Tue',
            'Wed',
            'Thu',
            'Fri',
            'Sat',
        ],
         title: {
            text: 'Weekdays'
        },
        crosshair: true
    },
    yAxis: {
        min: 0,
        title: {
            text: 'No of users'
        }
    },
    tooltip: {
        headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
        pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
            '<td style="padding:0"><b>{point.y} </b></td></tr>',
        footerFormat: '</table>',
        shared: true,
        useHTML: true
    },
    plotOptions: {
        column: {
            pointPadding: 0.1,
            borderWidth: 0
        }
    },
    series: [{
        name: 'Registered users in week',
        data: array

    },]
});