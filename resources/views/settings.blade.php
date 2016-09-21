@extends('layouts.dashboard')

@section('content')

<div class="am-content">
	<div class="page-head">
        <h2>Settings</h2>
        <p>Here you can update your settings</p>
    </div>

    <div class="main-content">

        


    	<div class="row">
    		<div class="col-md-6">
    			<div class="info-block panel panel-default">
    	   			<div class="panel-heading">
    	   			  <h4>Change your email</h4>
    	   			</div>

    	   			<div class="panel-body">

                        @if (count($errors) > 0)
                            @foreach ($errors->all() as $error)
                                <div role="alert" class="alert alert-warning alert-dismissible">
                                    <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-attention"></span><strong>Warning!</strong> {{$error}}
                                </div>
                            @endforeach
                        @endif

                        @if(Session::has('flash_message_email'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div role="alert" class="alert alert-success alert-dismissible">
                                        <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-check"></span><strong>Success!</strong>{{ Session::get('flash_message') }}
                                    </div>
                                </div>
                            </div>
                        @endif


    	   				<form role="form" method="POST" action="{{ url('/settings/update/email') }}">
                            {{ csrf_field() }}
                    		<div class="form-group">
                    		  <label>Your Email Address</label>
                    		  <input type="text" placeholder="{{ Auth::user()->email }}" class="form-control" name="email" required>
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
                      <h4>Change your password</h4>
                    </div>
                    <div class="panel-body">

                        @if(Session::has('flash_message_password'))
                            <div class="row">
                                <div class="col-md-12">
                                    <div role="alert" class="alert alert-warning alert-dismissible">
                                        <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-attention"></span><strong>Warning!</strong>{{ Session::get('flash_message_password') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        @if(Session::has('flash_message_password_success'))
                            <div class="row">
                                <div class="col-md-12">
                                     <div role="alert" class="alert alert-success alert-dismissible">
                                        <button type="button" data-dismiss="alert" aria-label="Close" class="close"><span aria-hidden="true" class="s7-close"></span></button><span class="icon s7-check"></span><strong>Success!</strong>{{ Session::get('flash_message_password_success') }}
                                    </div>
                                </div>
                            </div>
                        @endif

                        <form role="form" method="POST" action="{{ url('/settings/update/password') }}">
                            {{ csrf_field() }}
                            <div class="form-group">
                              <label>Current Password</label>
                              <input type="password" class="form-control" name="current_password" required>
                            </div>

                            <div class="form-group">
                              <label>New Password</label>
                              <input type="password" class="form-control" name="new_password" required>
                            </div>

                            <div class="form-group">
                              <label>Confirm Password</label>
                              <input type="password" class="form-control" name="confirm_new_password" required>
                            </div>

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