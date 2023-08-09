@extends('admin.admin_master')
@section('admin')


 <div class="content-wrapper">
	  <div class="container-full">
		<!-- Content Header (Page header) -->
	

<section class="content">

		 <!-- Basic Forms -->
		  <div class="box">
			<div class="box-header with-border">
			  <h4 class="box-title">Change Password</h4>
			  
			</div>
			<!-- /.box-header -->
			<div class="box-body">
			  <div class="row">
				<div class="col">

	 <form method="post" action="{{ route('user.password.update', ['id' => $editPassword->id]) }}">
	 	@csrf
					  <div class="row">
						<div class="col-12">	

		<div class="form-group">
		<h5>New Password  <span class="text-danger">*</span></h5>
		<div class="controls">
	 <input type="password" name="new_password" id="new_password" class="form-control" >
    @error('new_password')
	 <span class="text-danger">{{ $message }}</span>
	 @enderror

	   </div>
		 
	</div>
 
  
							 
						<div class="text-xs-right">
	 <input type="submit" class="btn btn-rounded btn-info mb-5" value="Submit">
						</div>
					</form>

				</div>
				<!-- /.col -->
			  </div>
			  <!-- /.row -->
			</div>
			<!-- /.box-body -->
		  </div>
		  <!-- /.box -->

		</section>


 
 
	  
	  </div>
  </div>





@endsection