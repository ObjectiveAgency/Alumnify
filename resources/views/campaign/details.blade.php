@extends('layouts.dashboard')

@section('content')

<div class="am-content">
  
  <div class="page-head">
    <div class="row">
      <div class="col-md-9">
        <h2>Campaigns</h2>
        <p>Here you can see the data from all your campaigns</p>
      </div>

      <div class="col-md-3">
        <br><br>
        <div class="dropdown pull-right">
          <form method="POST" action="">
            <div class="input-group xs-mb-15">
              <select class="form-control">
                <option >Campaign 1</option>
                <option>Campaign 2</option>
                <option>Campaign 3</option>
              </select><span class="input-group-btn">
              <button type="button" class="btn btn-primary">Go</button></span>
            </div>
          </form>
        </div>
      </div>

    </div>
    
  </div>
  
  <div class="main-content">

    <div class="row">
      <div class="col-md-12">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title text-center">Engagement Overview</span>
          </div>
          <div class="panel-body">
            <div class="row chart-info">
              <div class="col-md-3 text-center">
                <h1 class="superbig-text"><span data-toggle="counter" data-end="{{$ev->opens_total}}" class="number">0</span></h1><br>
                <span class="title">Opens</span>
              </div>
              <div class="col-md-3 text-center">
                <h1 class="superbig-text"><span data-toggle="counter" data-end="{{$ev->clicks_total}}" class="number">0</span></h1><br>
                <span class="title">Clicked</span>
              </div>
              <div class="col-md-3 text-center">
                <h1 class="superbig-text"><span data-toggle="counter" data-end="{{$ev->hard_bounce}}" class="number">0</span></h1><br>
                <span class="title">Bounced</span>
              </div>
              <div class="col-md-3 text-center">
                <h1 class="superbig-text"><span data-toggle="counter" data-end="{{$ev->unsubscribe}}" class="number">0</span></h1><br>
                <span class="title">Unsubscribed</span>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div><!-- end overview  -->

    <div class="row">
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Top 5 Most Engaged Users</span>
          </div>
          
          <div class="panel-body">
            <!-- display data here -->
            <ol>
              @foreach($top5->name as $list)
                <li>{{$list->name}}</li>
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
            <!-- display data here -->
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
            <!-- display data here -->
            <ol>

              @foreach($top5->age as $list)
                <li>{{$list->age}}</li>
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
            <span class="title">Top 5 Citites</span>
            
          </div>
          <div class="panel-body">
            <!-- display data here -->
            <ol>

              @foreach($top5->city as $list)
                <li>{{$list->city}}</li>
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
            <!-- display data here -->
            <ol>

              @foreach($top5->state as $list)
                <li>{{$list->state}}</li>
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
            <!-- display data here -->
            <ol>

              @foreach($top5->country as $list)
                <li>{{$list->country}}</li>
              @endforeach

            </ol>
          </div>
        </div>
      </div>
      <div class="col-md-6">
        <div class="panel panel-default">
          <div class="panel-heading">
            <span class="title">Open Rate per day</span>
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

    genderEngagement({{($top5['gender']['male']/$top5['gender']['total'])*100}},{{($top5['gender']['female']/$top5['gender']['total'])*100}});
    // var day ={mon:[],tue:[],wed:[],thur:[],fri:[],sat:[],sun:[]};
    // alert(day);
    openRatePerDay(10, 20, 5.7, 5, 11.9, 15.2, 4/6);

    });//end document ready

    
</script>

@endsection