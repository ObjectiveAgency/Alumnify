@extends('layouts.dashboard')

@section('css')

<link rel="stylesheet" type="text/css" href="/assets/lib/datatables/css/dataTables.bootstrap.min.css"/>

@endsection

@section('content')

<div class="am-content">
  
  <div class="page-head">
    <div class="row">
      <div class="col-md-6">
        <h2>Subscriber Profile</h2>
        <p></p>
      </div>

      <div class="col-md-6">
        <br><br>
        <div class="pull-right">
          <button formmethod="post" form="mainform" formaction="{{ url('/subscriber/delete') }}/{{$subscriber->id}}" class="btn btn-primary btn-lg  md-trigger">Delete Subscriber</button>
          <button formmethod="get" form="mainform" formaction="{{ url('/subscribers/') }}/{{$subscriber->list_id}}" class="btn btn-alt1 btn-lg">Back</button>
        </div>
      </div>

    </div>
    
  </div>
  
<div class="main-content">

          @if(Session::has('flash_message'))
          <div class="row">
              <div class="col-md-12">
                  <div role="alert" class="alert alert-success alert-dismissible">
                      <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-check"></span>{{ Session::get('flash_message') }}
                </div>
              </div>
          </div>
          @endif

          <div class="row">
            <div class="col-md-6">
              <div class="panel panel-default">
                <div class="panel-heading">Subscriber's Details</div>
                <div class="panel-body">
                  
                  <form id="mainform" role="form" method="POST" action="{{ url('/subscriber/update') }}/{{$subscriber->id}}">
                        {{ csrf_field() }}
                    <div class="form-group">
                      <label>First Name</label>
                      <input type="text" placeholder="{{ $subscriber->fname }}" class="form-control"  name="fname">
                    </div>
                    <div class="form-group">
                      <label>Last Name</label>
                      <input type="text" placeholder="{{ $subscriber->lname }}" class="form-control"  name="lname">
                    </div>
                    <div class="form-group">
                      <label>Email</label>
                      <input type="email" placeholder="{{ $subscriber->email }}" class="form-control"  name="email">
                    </div>
                    <div class="form-group">
                      <label>Gender</label>
                      <select class="form-control" name="gender">
                          @if($subscriber->gender == 'Male')
                            <option selected>Male</option>
                            <option>Female</option>
                          @else
                            <option>Male</option>
                            <option selected>Female</option>
                          @endif
                        </select>
                    </div>
                    <div class="form-group">
                      <label>Age</label>
                      <input type="text" placeholder="{{ $subscriber->age }}" class="form-control"  name="age">
                    </div>
                    <div class="form-group">
                      <label>City</label>
                      <input type="text" placeholder="{{ $subscriber->city }}" class="form-control"  name="city">
                    </div>
                    <div class="form-group">
                      <label>Country</label>
                      <input type="text" placeholder="{{ $subscriber->country }}" class="form-control"  name="country">
                    </div>
                    <div class="form-group">
                      <label>State</label>
                      <input type="text" placeholder="{{ $subscriber->state }}" class="form-control"  name="state">
                    </div>
                    <div class="form-group">
                      <label>Zip Code</label>
                      <input type="text" placeholder="{{ $subscriber->zip }}" class="form-control"  name="zip">
                    </div>

                    <br><br>
                    <div class="spacer">
                      <button type="submit" class="btn btn-space btn-lg btn-primary objective-success pull-right">Update</button>
                    </div>
                  </form>

                </div>
              </div>
            </div>

            <div class="col-md-6">
              <div class="panel panel-dark">
                <div class="panel-heading">
                  <span class="title">{{ $subscriber->fname }} {{$subscriber->lname}}'s Rank</span>
                </div>
                <div class="panel-body">
                  <center><h1>{{ $subscriber->rank }}</h1></center>
                </div>
              </div>
            </div>
            
          </div>
</div>

</div>

<!-- add subscriber modal -->
<div id="md-colored" tabindex="-1" role="dialog" class="modal fade modal-colored-header">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><i class="icon s7-close"></i></button>
        <h3 class="modal-title">Delete Confirmation</h3>
      </div>
      <form role="form" method="POST" action="{{ url('/subscriber/delete') }}">
        
      <div class="modal-body">
        <div class="text-center">
          <div class="i-circle text-primary"><i class="icon s7-attention"></i></div>
          <h4>Warning!</h4>
          <p>You are about to delete <strong>{{$subscriber->fname}} {{$subscriber->lname}}</strong> on the subscriber list.</p>
        </div>
        <br><br>
        {{ csrf_field() }}
      </div>
      
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn btn-danger">Delete</button>
      </div>

      </form>
    </div>
  </div>
</div>

@endsection

@section('javascripts')

<script src="/assets/lib/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/dataTables.buttons.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/buttons.html5.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/buttons.flash.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/buttons.print.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/buttons.colVis.js" type="text/javascript"></script>
<script src="/assets/lib/datatables/plugins/buttons/js/buttons.bootstrap.js" type="text/javascript"></script>
<script src="/assets/js/app-tables-datatables.js" type="text/javascript"></script>

<script type="text/javascript">
      
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
      });

</script>

@endsection