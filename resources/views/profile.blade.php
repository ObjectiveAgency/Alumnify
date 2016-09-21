@extends('layouts.dashboard')

@section('content')

<div class="am-content">
	<div class="page-head">
        <h2>Profile</h2>
        <p>Here you can edit your profile details</p>
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
    			<div class="info-block panel panel-default">
    	   			<div class="panel-heading">
    	   			  <h4>Personal Details</h4>
    	   			</div>
    	   			<div class="panel-body">
    	   				<form role="form" method="POST" action="{{ url('/profile/update') }}">
                            {{ csrf_field() }}
                    		<div class="form-group">
                    		  <label>Your Name</label>
                    		  <input type="text" placeholder="{{ Auth::user()->name }}" class="form-control" required name="name">
                    		</div>
                    		<div class="spacer">
                    		  <button type="submit" class="btn btn-space btn-primary">Update</button>
                    		</div>
                  		</form>
    	   			</div>
    			</div>
    		</div>
	
    		<div class="col-md-6">
    			<div class="info-block panel panel-default">
                    <div class="panel-heading">
                      <h4>Company Details</h4>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ url('/profile/update') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                              <label>Lorem Ipsum Details</label>
                              <input type="text" placeholder="{{ Auth::user()->company }}" class="form-control" required name="company">
                            </div>
                            <div class="spacer">
                              <button type="submit" class="btn btn-space btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
    	   			
    			</div>
    		</div>
    	</div>

    	<div class="row">
    		<div class="col-md-6">
    			<div class="info-block panel panel-default">
    	   			<div class="panel-heading">
                      <h4>Profile Image</h4>
                    </div>
                    <div class="panel-body">
                        <form role="form" method="POST" action="{{ url('/profile/update/image') }}" enctype="multipart/form-data">
                            <center>
                                <img src="assets/img/uploads/{{ Auth::user()->image }}" alt="..." class="img-circle" width="300px">
                                <br><br>
                                
                                {{ csrf_field() }}
                                <div class="form-group">
                                  <input type="file" name="image" class="form-control" required>
                                </div>
                                
                            </center>
                            <div class="spacer">
                                <button type="submit" class="btn btn-space btn-primary">Update</button>
                            </div>
                        </form>
                    </div>
    			</div>
    		</div>
    	</div>

    </div>


    

    
  </div>
</div>

@endsection