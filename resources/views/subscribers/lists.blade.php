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
        <h3>List Details</h3>
        {{ csrf_field() }}
        <br>
        
        
<div class="form-group">
          <input type="text" placeholder="List Name" class="form-control input-sm" required="" name="name">
        </div>
<div class="form-group">
          <input type="email" placeholder="From Email" class="form-control input-sm" required="" name="from_email">
        </div>


<div class="form-group">
          <input type="text" placeholder="From Name" class="form-control input-sm" required="" name="from_name">
        </div><div class="form-group">
          <textarea class="form-control input-sm" placeholder="Email description" name="permission_reminder" s required></textarea>
        </div>



<div class="form-group">
  <span class="lead"><h4><strong>Contact Info</strong></h4></span>
        </div>
<div class="form-group">
          <input value="{{$data->contact['company']}}" type="text" placeholder="Company Name" class="form-control input-sm" required="" name="company">
        </div><div class="form-group">
  <span class="lead"><h5>Address</h5></span>
        </div>

<div class="form-group">
          
<input value="{{$data->contact['addr1']}}" type="text" placeholder="Address 1" class="form-control input-sm" required="" name="address1">
        </div>
<div class="form-group">
          
<input value="{{$data->contact['addr2']}}" type="text" placeholder="Address 2" class="form-control input-sm" name="address2">
        </div>

<div class="form-group">
          
<input value="{{$data->contact['city']}}" type="text" placeholder="City" class="form-control input-sm" required="" name="city">
        </div>
<div class="form-group">
          
<input value="{{$data->contact['zip']}}" type="text" placeholder="Zip / Postal Code" class="form-control input-sm" required="" name="zip">
        </div>
<div class="form-group">
          
<input value="{{$data->contact['country']}}" type="text" placeholder="Country" class="form-control input-sm" required="" name="country">
        </div><div class="form-group">
          
<input value="{{$data->contact['state']}}" type="text" placeholder="State / Province / Region" class="form-control input-sm" required="" name="state">
        </div>
<div class="form-group">
          
<input type="text" placeholder="Phone" class="form-control input-sm" name="phone">
        </div><div class="form-group">
  <span class="lead"><h4>Email Notification <small>{{$data->email}}</small></h4></span>
        </div>
        

<div class="form-group">
        <label class="col-sm-3 control-label">Subscribe</label>
          <div class="">
            <div class="switch-button switch-button-success">
              <input type="checkbox" name="notify_on_subscribe" id="notify_on_subscribe" onclick="switch_btn(this.id)"><span>
              <label for="notify_on_subscribe"></label></span>
            </div>
          </div>
        </div>
<div class="form-group">
        <label class="col-sm-3 control-label">Unsubscribe</label>
          <div class="">
            <div class="switch-button switch-button-success">
              <input type="checkbox" name="notify_on_unsubscribe" id="notify_on_unsubscribe" onclick="switch_btn(this.id)"><span>
              <label for="notify_on_unsubscribe"></label></span>
            </div>
          </div>
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
function switch_btn(id)
{
    
    if( document.getElementById(id).checked){
        document.getElementById(id).value = "{{$data->email}}";
    }
}

</script>

@endsection