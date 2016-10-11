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
          <button class="btn btn-primary btn-lg  md-trigger" data-toggle="modal" data-target="#addlist" type="button">Add List</button>
          <!-- <button type="button" class="btn btn-alt1 btn-lg">Upload CSV</button> -->
        </div>
      </div>

    </div>
    
  </div>
  
<div class="main-content">

          @if(Session::get('flash_message')!=='success')
          <script type="text/javascript">
              document.querySelector("div.alert.alert-success.alert-dismissible").className = "alert alert-danger alert-dismissible";
              document.querySelector("span.icon.s7-check").className = "icon s7-close-circle";
          </script>
          @endif

          <div class="row">
            <div class="col-sm-12">
              <div class="widget widget-fullwidth widget-small">
                <div class="widget-head">
                  <div class="title">Please Select on your List</div>
                </div>
                <table id="table1" class="table table-striped table-hover table-fw-widget">
                  <thead>
                    <tr>
                      <th>Name</th>
                    </tr>
                  </thead>
                  <tbody>
                    @foreach ($lists as $list)
                      <tr>
                        <td><a href="/subscribers/{{$list->id}}">{{ $list->name }}</a></td>
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
<div id="addlist" tabindex="-1" role="dialog" class="modal fade modal-colored-header modal-colored-header-objective">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><i class="icon s7-close"></i></button>
        <h3 class="modal-title">Add List</h3>
      </div>
      <form role="form" method="POST" action="{{ url('subscriber/list/add') }}">

      <div class="modal-body">
        <h4>Here you can manually add a new list</h4>
        <br><br>
        {{ csrf_field() }}
        <div class="form-group">
          <input type="text" placeholder="List Name" class="form-control" required name="listName">
        </div>

      </div>
      
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn btn-objective">Add</button>
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