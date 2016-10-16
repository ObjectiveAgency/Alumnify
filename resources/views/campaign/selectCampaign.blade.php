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
                <option>Choose a campaign</option>
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