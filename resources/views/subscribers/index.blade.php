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
          <button type="button" class="btn btn-primary btn-lg">Add Subscriber</button>
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
                  <div class="title title dataTables_wrapper form-inline dt-bootstrap no-footer">
                  <select class="form-control input-sm">
                    <option value="All">All Subscribers</option>
                  </select>

                  </div>
                </div>
                <table id="table1" class="table table-striped table-hover table-fw-widget">
                  <thead>
                    <tr>
                      <th>Name</th>
                      <th>Email</th>
                      <th>Gender</th>
                      <th>Age</th>
                      <th>Address</th>
                      <th>City</th>
                      <th>State</th>
                      <th>Country</th>
                      <th>Zip</th>
                    </tr>
                  </thead>
                  <tbody>
<?php $faker = Faker\Factory::create(); ?>
                  @for($i=0;$i<100;$i++)
<?php 
$gender = $faker->numberBetween($min = 0, $max = 1);
if($gender === 0){
  $gender = 'female';
}else{
  $gender = 'male';
}
$address = $faker->address;
$zip = substr($address,strpos($address,",")+5);
$address = substr($address,0,strpos($address,",")+4);
?>
                    <tr class="odd gradeX">
                      <td>{{$faker->name($gender)}}</td>

                      <td>{{$faker->email}}</td>
                      <td>{{$gender}}</td>
                      <td class="center">{{$faker->numberBetween($min = 20, $max = 30)}}</td>
                      <td>{{$faker->streetName}}</td>
                      <td>{{$faker->city}}</td>
                      <td>{{$faker->state}}</td>
                      <td>{{$faker->country}}</td>
                      <td>{{$faker->postcode}}</td>
                    </tr>
                    @endfor

                  </tbody>
                </table>
              </div>
            </div>
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