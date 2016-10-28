@extends('layouts.dashboard')

@section('content')

<div class="am-content">
  
  <div class="page-head">
    <div class="row">
      <div class="col-md-8">
        <h2>Dashboard</h2>
        <p>Here you can see the data from all your campaigns</p>
      </div>
      
      <div class="col-md-4">
      <br><br>
        <button type="button" class="btn btn-space btn-success pull-right" id="download_pdf"><i class="icon icon-left s7-cloud-download"></i> Download PDF</button>
      </div>
    </div>
  </div>
  
  <div class="main-content front">

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Most Engaged Customer Demographic</span>
          </div>
          
          <div class="panel-body">
           {{ucwords($charts->tmp[0])}}, {{ucwords($charts['age']->first()->age)}}, {{ucwords($charts['city']->first()->city)}}, {{ucwords($charts['state']->first()->state)}}
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Least Engaged Customer Demographic</span>
          </div>
          <div class="panel-body">
            {{ucwords($charts->tmp[1])}}
            @foreach($charts['least'] as $item)
              ,{{$item[0]}}
            @endforeach
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Top 5 Most Engaged Users</span>
          </div>
          <div class="panel-body">
             <ol>
            
            @foreach($charts['top5'] as $item)
            <li>{{$item->name}}</li>
            
            @endforeach
            </ol>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Top 5 Least Engaged Users</span>
          </div>
          <div class="panel-body">
             <ol>
            
            @foreach($charts['least5'] as $item)
            <li>{{$item->name}}</li>
            
            @endforeach
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Gender User Engagement</span>
          </div>
          <div class="panel-body">
              <div id="genderEngagement"></div>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Top 5 Age Engagement</span>
          </div>
          <div class="panel-body">
             <ol>
            
            @foreach($charts['age'] as $item)
            <li>{{$item->age}}</li>
            
            @endforeach
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Top 5 Cities</span>
          </div>
          <div class="panel-body">
             <ol>
            
            @foreach($charts['city'] as $item)
            <li>{{$item->city}}</li>
            
            @endforeach
            </ol>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Top 5 States</span>
          </div>
          <div class="panel-body">
            <ol>
            
            @foreach($charts['state'] as $item)
            <li>{{$item->state}}</li>
            
            @endforeach
            </ol>
          </div>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Top 5 Country</span>
          </div>
          <div class="panel-body">
            <ol>
            
            @foreach($charts['countries'] as $item)
            <li>{{$item->country}}</li>
            
            @endforeach
            </ol>
          </div>
        </div>
      </div>

      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Top 5 Campaigns</span>
          </div>
          <div class="panel-body">
             <ol>
            
            @foreach($charts['campaign'] as $item)
            <li>{{$item->name}}</li>
            
            @endforeach
            </ol>
          </div>
        </div>
      </div>
    </div>
        
    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Open Rate per Month</span>
          </div>
          <div class="panel-body">
            <div id="open-rate-per-day" style="min-width: 310px; height: 400px; margin: 0 auto"></div>
          </div>
        </div>
      </div>
    </div>

  </div><!-- end main-content  -->

</div>


@endsection


@section('javascripts')


<script src="/assets/lib/jquery.sparkline/jquery.sparkline.min.js" type="text/javascript"></script>
<script src="/assets/lib/jquery-ui/jquery-ui.min.js" type="text/javascript"></script>
<script src="/assets/lib/countup/countUp.min.js" type="text/javascript"></script>
<script src="/assets/lib/chartjs/Chart.min.js" type="text/javascript"></script>
<script src="/assets/js/app-dashboard.js" type="text/javascript"></script>
<script src="/assets/lib/highcharts.js"></script>
<script src="/assets/js/charts.js" type="text/javascript"></script>

<script type="text/javascript">
  $(document).ready(function(){
    //initialize the javascript
    App.init();
    
    counter();
   // alert({!!json_encode($charts['line']->toArray())!!});

   
   genderEngagement({{($charts['gender']['male']/$charts['gender']['total'])*100}},{{($charts['gender']['female']/$charts['gender']['total'])*100}});

    // alert({{json_encode($charts['line']->toArray())}});{!!json_encode($charts['line']->toArray())!!};
    month  = {!!json_encode($charts['line']->toArray())!!};
    openRatePerMonth(month); //please pass 12 params here, put 0 for null values

    });//end document ready

    
</script>

<script src="/assets/js/jspdf.min.js"></script>
<script src="/assets/js/html2canvas.min.js"></script>
<script src="/assets/js/pdf.js"></script>

@endsection