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
    <div class="row">
      <div class="col-md-4">
        <div class="panel panel-default">

            <div class="panel-heading"><span class="title">Connect Mailchimp</span></div>
            
            <div class="panel-body">
                <p>Before you can use Alumnify Dashboard you need to connect your Mailchimp account. Please have your username and password ready.</p>

                <br><br><br>

                @if (empty(Auth::user()->OAuth))
                  <button type="button" class="btn btn-space btn-primary btn-rounded btn-lg  md-trigger" data-modal="form-primary"><i class="icon icon-left s7-plug"></i> Connect</button>
                @else
                  <button type="button" class="btn btn-space objective-success btn-rounded btn-lg"><i class="icon icon-left s7-plug"></i> Connected</button>
                @endif
            </div>

            <!-- Nifty Modal-->
            <div id="form-primary" class="modal-container modal-colored-header custom-width modal-effect-9" style="perspective: 1300px; height: 528px;">
              <div class="modal-content">
                <form action="http://login.mailchimp.com/oauth2/authorize-post" id="login-form" method="POST" novalidate="novalidate">
                <div class="modal-header objective-bg">
                  <button type="button" data-dismiss="modal" aria-hidden="true" class="close modal-close"><i class="icon s7-close"></i></button>
                  <h3 class="modal-title">Connect Mailchimp</h3>
                </div>
                 
                  <input type="hidden" aria-hidden="true" name="multiple" class="av-hidden" value="" id="multiple"> 
                  <input type="hidden" aria-hidden="true" name="referrer" class="av-hidden" value="" id="referrer"> 
                  <input type="hidden" aria-hidden="true" name="p" class="av-hidden" value="eyJjbGllbnRfaWQiOiIyNzcyNzQ5OTEwNTkiLCJyZXNwb25zZV90eXBlIjoiY29kZSIsInJlZGlyZWN0X3VyaSI6Imh0dHA6XC9cL2xvY2FsLmFsdW1uaWZ5LmRldlwvY29ubmVjdGlvbnNcL2FkZCIsInN0YXRlIjpudWxsLCJzY29wZSI6bnVsbH0=" id="p">

                <div class="modal-body form">
                  <div class="form-group">
                    <label>User Name</label>
                    <input type="text" name="username" class=" av-text form-control" value="" id="username">
                  </div>
                  <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" class=" av-password form-control" value="" id="password">
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="button" data-dismiss="modal" class="btn btn-default modal-close">Cancel</button>
                  <button type="submit" data-dismiss="modal" class="btn btn-primary modal-close objective-bg">Proceed</button>
                </div>
                </form>
              </div>
            </div>
            
            <div class="modal-overlay"></div>
              
        </div>
      </div>

    </div>
  </div>

</div>

@endsection


@section('javascripts')

    <script src="assets/lib/jquery/jquery.min.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.nanoscroller/javascripts/jquery.nanoscroller.min.js" type="text/javascript"></script>
    <script src="assets/js/main.js" type="text/javascript"></script>
    <script src="assets/lib/jquery.niftymodals/dist/jquery.niftymodals.js" type="text/javascript"></script>
    <script type="text/javascript">
      //Set Nifty Modals defaults
      $.fn.niftyModal('setDefaults',{
        overlaySelector: '.modal-overlay',
        closeSelector: '.modal-close',
        classAddAfterOpen: 'modal-show',
      });

      $(document).ready(function(){
        //initialize the javascript
        App.init();
      });
    </script>

@endsection