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