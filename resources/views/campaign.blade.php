@extends('layouts.dashboard')

@section('content')

<div class="am-content">
  
  <div class="page-head">
    <div class="row">
      <div class="col-md-6">
        <h2>Campaigns</h2>
        <p>Here you can see the data from all your campaigns</p>
      </div>

      <div class="col-md-6">
        <br><br>
        <div class="dropdown pull-right">
          <a class="button-classes" href="#" id="ddm1" data-toggle="dropdown">
            Choose Campaign
            <span class="caret"></span>
          </a>
          <ul class="dropdown-menu">
            <li><a href="#">Campaign 1</a></li>
            <li><a href="#">Campaign 2</a></li>
            <li><a href="#">Campaign 3</a></li>
          </ul>
        </div>
      </div>

    </div>
    
  </div>
  
  <div class="main-content">
    <h3 class="text-center">Content goes here!</h3>
  </div>

</div>

@endsection