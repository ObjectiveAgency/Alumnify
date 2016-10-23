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
  

  function openRatePerDay(mon, tue, wed, thurs, fri, sat, sun){
    var weekdays = [];
    for (var i=0; i<7; i++) {
        var date = new Date();
        date.setDate(date.getDate() - i);
        var day = date.getDay()
        // weekdays.push( d.getDay() );
        switch (day ) {
            case 0:
                weekdays.push('Monday');
            break;

            case 1:
                weekdays.push('Tuesday');
            break;

            case 2:
                weekdays.push('Wednesday');
            break;

            case 3:
                weekdays.push('Thursday');
            break;

            case 4:
                weekdays.push('Friday');
            break;

            case 5:
                weekdays.push('Saturday');
            break;

            case 6:
                weekdays.push('Sunday');
            break;
        }
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
            categories: weekdays
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
            data: weekdays
        }]
    });

  }

function openRatePerMonth(jan, feb, march, april, may, jun, july, aug, sept, oct, nov, dec){

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
            data: [jan, feb, march, april, may, jun, july, aug, sept, oct, nov, dec]
        }]
    });

  }