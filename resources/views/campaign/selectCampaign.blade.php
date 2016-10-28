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
        <div class="btn-group btn-hspace pull-right">
          <button type="button" data-toggle="dropdown" class="btn btn-default dropdown-toggle" aria-expanded="false">Select a campaign <span class="caret"></span></button>
          <ul role="menu" class="dropdown-menu">
            @foreach($campaigns as $campaign)
              <li><a href="{{ url('/campaign') }}/{{$campaign->id}}">{{$campaign->name}}</a></li>
            @endforeach
          </ul>
        </div>
      </div>

    </div>
    
  </div>
  
  <div class="main-content">

  @if(Session::has('flash_message'))

          
          <div class="row">
              <div class="col-md-12">
                  <div id="back" role="alert" class="alert alert-success alert-dismissible">
                      <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span id="icon" class="icon s7-check"></span>{{ Session::get('flash_message') }}
                </div>
              </div>
          </div>
          @endif

          @if(Session::get('alertType')===0)

          <script type="text/javascript">
              document.querySelector("div.alert.alert-success.alert-dismissible").className = "alert alert-danger alert-dismissible";
              document.querySelector("span.icon.s7-check").className = "icon s7-close-circle";
          </script>
          @endif

    <div class="row">
      <div class="col-md-12">
        @if(count($campaigns) > 0 )
        <div class="panel panel-default">
          <div class="panel-heading">Please Select a Campaign</div>
          <div class="panel-body">          
            <div class="list-group">
            @foreach($campaigns as $campaign)
              <a class="list-group-item" href="{{ url('/campaign') }}/{{$campaign->id}}">{{ $campaign->name }}</a>
            @endforeach
            </div>          
          </div>
        </div>

        @else
            <center><h1>No campaigns found!</h1></center>
        @endif
      </div>
    </div><!-- end overview  -->
        
  </div><!-- end main-content  -->

</div>

@endsection