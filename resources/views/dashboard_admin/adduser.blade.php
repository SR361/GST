@extends('layouts_admin.master') 
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">Add User</h1>
				</div>
				<!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url('admin/dashboard') }}">Home</a></li>
						<li class="breadcrumb-item"><a href="{{ url('admin/products') }}">User List</a></li>
						<li class="breadcrumb-item active">Add User</li>
					</ol>
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</div>
	<!-- /.content-header -->
	<!-- Main content -->
	@if ($errors->any())
	<div class="alert alert-danger">
		<strong>Whoops!</strong> There were some problems with your input.<br><br>
		<ul>
			@foreach ($errors->all() as $error)
			<li>{{ $error }}</li>
			@endforeach
		</ul>
	</div>
	@endif

	<section class="content">
		<div class="row">
			<div class="col-12">
				@if(isset($user))        
				<form action="{{ route('users.update',$user->id) }}" method="POST"  id="form_data" enctype="multipart/form-data">
				<input type="hidden" value="{{ $user->id }}" name="id"> 
				 @method('PUT')      
					@else
					<form action="{{ route('users.store',app()->getLocale()) }}" method="POST" id="form_data"  enctype="multipart/form-data" autocomplete="off">     
						@endif
						@csrf
					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<label>User Name</label>
								<input type="text" style="width:50%"  class="form-control" name="name" placeholder="Enter User Name" value="@if(isset($user))  {{ $user->name }} @endif">
							</div>
							<div class="form-group">
								<label>Email</label>
								<input type="email" style="width:50%"  class="form-control" name="email" placeholder="Enter Email Name" value="@if(isset($user))  {{ $user->email }} @endif" <?php if(isset($user)){ echo 'disabled';} ?>>
							</div>
							<div class="form-group">
								<label>Password</label>
								<input type="password" style="width:50%"  class="form-control" name="password" placeholder="Enter Password Name" value="<?php if(isset($user)){ echo base64_decode($user->ch_pass); } ?>">
							</div>

							<div class="form-group">
								<label>Expired Date</label>
								<input type="text" style="width:50%"  class="form-control datepicker" name="expire_date" placeholder="Enter Expire Date" value="<?php if(isset($user)){ echo date('d-m-Y',strtotime($user->expire_date)); } ?>">
							</div>

							<div class="form-group"><label for="exampleInputFile">User Profile</label>
								<div class="row">
									<div class="col-lg-4 col-md-4 col-xs-4">
										<span class="btn btn-primary btn-file"> Browse
											<input type="file" class="form-control btn" accept="image/png,image/jpg,image/jpeg" name="logo" onchange="image_readURL(this);" id="exampleInputFile"/>
										</span>
									</div>
									<div class="col-lg-4 col-md-4 col-xs-4">
										@if(isset($user))  
										<img id="image" src="{{ asset('/public/images/users/'.$user->logo) }}" alt="" height="160" width="160" />                    
										@else
										<img id="image" src="" alt="" height="160" width="160" style="display: none;" />   
										@endif
									</div>
								</div>
							</div>
							<div class="card-footer">

								<button type="submit" name="submit" class="btn btn-primary">Submit</button>
								<button type="button" name="back" onClick="javascript:history.go(-1);" class="btn btn-secondary"><i
									class="fa fa-chevron-circle-left"> &nbsp;</i>Back
								</button>
							</div>
						</div>
					</div>
				</form>

			</div>
		</div>
		<!-- /.row -->
	</section>
</div>
@endsection
<script src="{{ asset('/public/dist/plugins/jquery/jquery.min.js') }}"></script>
<script>
	function image_readURL(input) {
		if (input.files && input.files[0]){
			var reader = new FileReader();
			reader.onload = function(e) {
				$('#image').show();
				$('#image').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}}


		$(document).ready(function() {
    $('.datepicker').datepicker({
        format: 'dd-mm-yyyy'
    });
});
</script>
