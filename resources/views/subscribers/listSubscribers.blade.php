@extends('layouts.dashboard')

@section('css')

<link rel="stylesheet" type="text/css" href="/assets/lib/datatables/css/dataTables.bootstrap.min.css"/>

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
          <button type="button" class="btn btn-alt1 btn-lg md-trigger"  data-toggle="modal" data-target="#csvform">Upload CSV</button>
          <button type="button" class="btn btn-default btn-lg md-trigger"  data-toggle="modal" data-target="#deleteList">Delete List</button>
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
                  <div class="title"> {{$listName}} </div>
                </div>
                
                <table id="table1" class="table table-striped table-hover table-fw-widget">
                  <thead>
                    <tr>
                      <th>First Name</th>
                      <th>Last Name</th>
                      <th>Age</th>
                      <th>Gender</th>
                      <th>Rank</th>
                      <th>&nbsp;</th>
                    </tr>
                  </thead>
                  <tbody>
                    @if( count($subscribers) > 0 )
                      
                      @foreach($subscribers as $subscriber)

                      <tr>
                        <td>{{$subscriber->fname}}</td>
                        <td>{{$subscriber->lname}}</td>
                        <td>{{$subscriber->age}}</td>
                        <td>{{$subscriber->gender}}</td>
                        <td>{{$subscriber->rank}}</td>
                        <td><a href="/subscribers/{{$subscriber->list_id}}/{{$subscriber->id}}">Details</a></td>
                      </tr>

                      @endforeach
                    @else

                    @endif
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
      <form role="form" method="POST" action="{{ url('/subscriber/add') }}/{{$list_id}}">

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
          <input type="text" placeholder="Address" class="form-control" required name="address">
        </div>

        <div class="form-group">
          <input type="text" placeholder="City" class="form-control" required name="city">
        </div>

        <div class="form-group">
          <input type="text" placeholder="State" class="form-control" required name="state">
        </div>

        <div class="form-group">
          <input type="text" placeholder="Zip Code" class="form-control" required name="zip">
        </div>

        <div class="form-group">
          <input type="text" placeholder="Country" class="form-control" required name="country">
          <input type="hidden" name="status" value="subscribed">
        </div>

      </div>
      
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn objective-bg">Add</button>
      </div>

      </form>
    </div>
  </div>
</div>



<div id="csvform" tabindex="-1" role="dialog" class="modal fade modal-colored-header modal-colored-header-objective">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><i class="icon s7-close"></i></button>
        <h3 class="modal-title">Add Subscriber</h3>
      </div>
      <form role="form" method="POST" action="{{ url('/subscriber/add/bulk') }}/{{$list_id}}"  enctype="multipart/form-data">

      <div class="modal-body">
        <h4>Please upload your csv file.</h4>
        <br><br>
        {{ csrf_field() }}
        <div class="form-group">
          <input type="file" required name="csvfile" accept=".csv">
        </div>

      </div>
      
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn objective-bg">Add</button>
      </div>

      </form>
    </div>
  </div>
</div>


<div id="deleteList" tabindex="-1" role="dialog" class="modal fade modal-colored-header modal-colored-header-warning">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" data-dismiss="modal" aria-hidden="true" class="close"><i class="icon s7-close"></i></button>
        <h3 class="modal-title">Delete Confirmation</h3>
      </div>
      <form role="form" method="POST" action="{{ url('/subscriber/list/delete') }}"  enctype="multipart/form-data">

      <div class="modal-body">
        <div class="text-center">
          <div class="i-circle text-warning"><i class="icon s7-attention"></i></div>
          <h4>Warning!</h4>
          <p>You are about to delete this list and it's subscribers!</p>
        </div>
        {{ csrf_field() }}
        <div class="form-group">
          <input type="hidden" required name="list_id" value="{{$list_id}}">
        </div>

      </div>
      
      <div class="modal-footer">
        <button type="button" data-dismiss="modal" class="btn btn-default">Cancel</button>
        <button type="submit" class="btn btn-warning">Delete</button>
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