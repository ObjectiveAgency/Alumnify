    //Counter
    function counter(){

      $('[data-toggle="counter"]').each(function(i, e){
        var _el       = $(this);
        var prefix    = '';
        var suffix    = '';
        var start     = 0;
        var end       = 0;
        var decimals  = 0;
        var duration  = 2.5;

        if( _el.data('prefix') ){ prefix = _el.data('prefix'); }

        if( _el.data('suffix') ){ suffix = _el.data('suffix'); }

        if( _el.data('start') ){ start = _el.data('start'); }

        if( _el.data('end') ){ end = _el.data('end'); }

        if( _el.data('decimals') ){ decimals = _el.data('decimals'); }

        if( _el.data('duration') ){ duration = _el.data('duration'); }

        var count = new CountUp(_el.get(0), start, end, decimals, duration, { 
          suffix: suffix,
          prefix: prefix,
        });

        count.start();
      });
    }


  function genderEngagement(male, female){
    // Gender user engagement pie
        $('#genderEngagement').highcharts({
            chart: {
            type: 'pie'
        },
        title: {
            text: ''
        },
        subtitle: {
            text: ''
        },
        plotOptions: {
            series: {
                dataLabels: {
                    enabled: true,
                    format: '{point.name}: {point.y:.1f}%'
                }
            }
        },

        tooltip: {
            headerFormat: '<span style="font-size:11px">{series.name}</span><br>',
            pointFormat: '<span style="color:{point.color}">{point.name}</span>: <b>{point.y:.2f}%</b> of total<br/>'
        },
            series: [{
                name: 'Gender',
                colorByPoint: true,
                data: [{
                    name: 'Male',
                    y: male
                }, {
                    name: 'Female',
                    y: female
                }]
            }]
        });
  }
  

  function openRatePerDay(data){

    var days = ['Sunday','Monday','Tuesday','Wednesday','Thursday','Friday','Saturday'];

        week = [];

        day = new Date(Object.keys(data)[Object.keys(data).length -1 ]);

        values = [];

        for(i=0;i<7;i++){

            week.push(days[day.getDay()]);

            for(var key in data){

                if((new Date(key)).toString() === day.toString()){

                values.push(data[key]);

                 }
            }

            if(values[i]===undefined)

            values.push(0);

            day.setDate(day.getDate() - 1);

        }
    $('#open-rate-per-day').highcharts({
        title: {
            text: '',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: week.reverse()
        },
        yAxis: {
            title: {
                text: 'Percentage (%)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '%'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Open Rate',
            data: values.reverse()
        }]
    });

  }

function openRatePerMonth(data){

    month = {January:0, February:0, March:0, April:0, May:0, June:0, July:0, August:0, September:0, October:0, November:0, December:0}
    
    for(var key in data){
    month[key] = data[key];
    }

    $('#open-rate-per-day').highcharts({
        title: {
            text: '',
            x: -20 //center
        },
        subtitle: {
            text: '',
            x: -20
        },
        xAxis: {
            categories: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']
        },
        yAxis: {
            title: {
                text: 'Percentage (%)'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: '%'
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: 'Open Rate',
            data: [month['January'], month['February'], 
            month['March'], month['April'], month['May'], month['June'], month['July'], 
            month['August'], month['September'], month['October'], month['November'], month['December']]
        }]
    });

  }
