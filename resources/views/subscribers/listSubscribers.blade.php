@extends('layouts.dashboard')

@section('css')

<link rel="stylesheet" type="text/css" href="assets/lib/datatables/css/dataTables.bootstrap.min.css"/>

@endsection

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
          <button class="btn btn-primary btn-lg  md-trigger" data-toggle="modal" data-target="#md-colored" type="button">Add Subscriber</button>
          <button type="button" class="btn btn-alt1 btn-lg">Upload CSV</button>
        </div>
      </div>

    </div>
    
  </div>
  
<div class="main-content">
          <div class="row">
            <div class="col-sm-12">
              <div class="widget widget-fullwidth widget-small">
                <div class="widget-head">
                  <div class="title">{{ $listName }}</div>
                </div>
                <table id="table1" class="table table-striped table-hover table-fw-widget">
                  <thead>
                    <tr>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Email</th>
                      <th>Age</th>
                      <th>Gender</th>
                      <th>Address</th>
                      <th>City</th>
                      <th>State</th>
                      <th>Country</th>
                      <th>Zip Code</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($subscribers as $subscriber)
                      <tr>
                        <td><a href="/subscribers/{{$subscriber->id}}">{{ $subscriber->fname }}</a></td>
                      </tr>
                    @endforeach
                  </tbody>
                </table>
              </div>
            </div>
          </div>
</div>

</div>

<!-- add subscriber modal -->
<div id="md-colored" tabindex="-1" role="dialog" class="modal fade modal-colored-header modal-colored-header-objective">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><i class="icon s7-close"></i></button>
        <h3 class="modal-title">Add Subscriber</h3>
      </div>
      <form role="form" method="POST" action="{{ url('/subscribers/add') }}">

      <div class="modal-body">
        <h4>Here you can manually add a subscriber</h4>
        <br><br>
        {{ csrf_field() }}
        <div class="form-group">
          <input type="text" placeholder="First Name" class="form-control" required name="fname">
        </div>

        <div class="form-group">
          <input type="text" placeholder="Last Name" class="form-control" required name="lname">
        </div>

        <div class="form-group">
          <input type="text" placeholder="Email Address" class="form-control" required name="email">
        </div>

        <div class="form-group">
          <input type="text" placeholder="Gender" class="form-control" required name="gender">
        </div>

        <div class="form-group">
          <input type="text" placeholder="Age" class="form-control" required name="age">
        </div>

        <div class="form-group">
          <input type="text" placeholder="City" class="form-control" required name="city">
        </div>

        <div class="form-group">
          <input type="text" placeholder="State" class="form-control" required name="state">
        </div>

        <div class="form-group">
          <input type="text" placeholder="Zip Code" class="form-control" required name="zipCode">
        </div>

        <div class="form-group">
          <input type="text" placeholder="Country" class="form-control" required name="country">
        </div>

      </div>
      
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        <button type="submit" data-dismiss="modal" class="btn btn-objective">Add</button>
      </div>

      </form>
    </div>
  </div>
</div>

@endsection

@section('javascripts')

<script src="assets/lib/datatables/js/jquery.dataTables.min.js" type="text/javascript"></script>
<script src="assets/lib/datatables/js/dataTables.bootstrap.min.js" type="text/javascript"></script>
<script src="assets/lib/datatables/plugins/buttons/js/dataTables.buttons.js" type="text/javascript"></script>
<script src="assets/lib/datatables/plugins/buttons/js/buttons.html5.js" type="text/javascript"></script>
<script src="assets/lib/datatables/plugins/buttons/js/buttons.flash.js" type="text/javascript"></script>
<script src="assets/lib/datatables/plugins/buttons/js/buttons.print.js" type="text/javascript"></script>
<script src="assets/lib/datatables/plugins/buttons/js/buttons.colVis.js" type="text/javascript"></script>
<script src="assets/lib/datatables/plugins/buttons/js/buttons.bootstrap.js" type="text/javascript"></script>
<script src="assets/js/app-tables-datatables.js" type="text/javascript"></script>

<script type="text/javascript">
      
      $(document).ready(function(){
        //initialize the javascript
        App.init();
        App.dataTables();
      });
</script>

@endsection