@extends('layouts.dashboard')

@section('content')

<div class="am-content">
  
  <div class="page-head">
    <div class="row">
      <div class="col-md-6">
        <h2>Connections</h2>
        <p>Connect your accounts to other apps</p>
      </div>

      <div class="col-md-6">
        <br><br>
      </div>

    </div>
    
  </div>
  
  <div class="main-content">
    <h3 class="text-center">Content goes here!</h3>
  </div>
  <div class"text-center">
    <iframe id="iframe" width="500" height="500" src="https://login.mailchimp.com/oauth2/authorize?response_type=code&client_id=277274991059" frameborder="0" allowfullscreen="">
    </iframe>
  </div>

</div>

@endsection