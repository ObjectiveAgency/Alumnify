@extends('layouts.dashboard')

@section('content')

<div class="am-content">
  
  <div class="page-head">
    <div class="row">
      <div class="col-md-6">
        <h2>Subscribers</h2>
        <p>This is the list of everyone on your mailing list.</p>
      </div>

      <div class="col-md-6">
        <br><br>
        <div class="pull-right">
          <button type="button" class="btn btn-primary btn-lg">Add Subscriber</button>
          <button type="button" class="btn btn-alt1 btn-lg">Upload CSV</button>
        </div>
      </div>

    </div>
    
  </div>
  
  <div class="main-content">
    <h3 class="text-center">Content goes here!</h3>
  </div>

</div>

@endsection