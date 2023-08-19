@extends('layouts.master') 
@section('content')
<div class="content-wrapper">
	<!-- Content Header (Page header) -->
	<div class="content-header">
		<div class="container-fluid">
			<div class="row mb-2">
				<div class="col-sm-6">
					<h1 class="m-0 text-dark">{{ trans('app.Add Employee') }}</h1>
				</div>
				<!-- /.col -->
				<div class="col-sm-6">
					<ol class="breadcrumb float-sm-right">
						<li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/dashboard') }}">{{ trans('app.Home') }}</a></li>
						<li class="breadcrumb-item"><a href="{{ url(app()->getLocale().'/employees') }}">{{ trans('app.Employee List') }}</a></li>
						<li class="breadcrumb-item active">{{ trans('app.Add Employee') }}</li>
					</ol>
				</div>
				<!-- /.col -->
			</div>
			<!-- /.row -->
		</div>
		<!-- /.container-fluid -->
	</div>
	

	<section class="content">
		<div class="col-md-12 row">
			<div class="col-md-6">
				@if(isset($user))        
				<form action="{{ route('employees.update',[app()->getLocale(),$user->id]) }}" method="POST"  id="form_data" enctype="multipart/form-data">
				<input type="hidden" value="{{ $user->id }}" name="id"> 
				 @method('PUT')      
					@else
					<form action="{{ route('employees.store',app()->getLocale()) }}" method="POST" id="form_data"  enctype="multipart/form-data">
						@endif
						@csrf
					<div class="card">
						<div class="card-body">
							<div class="form-group">
								<label>{{ trans('app.Role') }}</label>
									<select class="form-control select2" name="role_id"  id="role_id" style="border-color: @if ($errors->get('role_id')) {{ '#e74c3c' }} @endif">
										<option selected disabled value="">{{ trans('app.Select One Role') }}</option>
										@foreach($role as $role_data)
										<option value="{{ $role_data->id }}" <?php if(isset($user)){if($user->role_type == $role_data->id){echo "selected";}} ?> >{{ $role_data->name }}</option>
										@endforeach
									</select>
									<label style="color: red;">@if ($errors->get('role_id'))
									@foreach ($errors->get('role_id') as $error)
									{{ $error }}
									@endforeach
								@endif</label>
							</div>

							<div class="form-group">
								<label>{{ trans('app.Employee Name') }}</label>
								<input type="text" class="form-control" name="name" value="@if(isset($user)){{ $user->name }}@else {{ old('name') }}@endif" style="border-color: @if ($errors->get('name')) {{ '#e74c3c' }} @endif">
								<label style="color: red;">@if ($errors->get('name'))
									@foreach ($errors->get('name') as $error)
									{{ $error }}
									@endforeach
								@endif</label>
							</div>

							<div class="form-group">
								<label>{{ trans('app.Email') }}</label>
								<input type="email"  class="form-control" name="email"  value="@if(isset($user)){{ $user->email }}@else {{old('email')}}@endif" <?php if(isset($user)){echo 'disabled'; } ?> style="border-color: @if ($errors->get('email')) {{ '#e74c3c' }} @endif">
								<label style="color: red;">@if ($errors->get('email'))
									@foreach ($errors->get('email') as $error)
									{{ $error }}
									@endforeach
								@endif</label>
							</div>

							<div class="form-group">
								<label>{{ trans('app.Password') }}</label>
								<input type="password"  class="form-control" name="password"  value="<?php if(isset($user)){ echo base64_decode($user->ch_pass); }else{ echo old('password'); } ?>" style="border-color: @if ($errors->get('password')) {{ '#e74c3c' }} @endif">
								<label style="color: red;">@if ($errors->get('password'))
									@foreach ($errors->get('password') as $error)
									{{ $error }}
									@endforeach
								@endif</label>
							</div>

							<div class="form-group">
								<label>{{ trans('app.Reenter Password') }}</label>
								<input type="password"  class="form-control" name="repassword"  value="<?php if(isset($user)){ echo base64_decode($user->ch_pass); }else{ echo old('repassword'); } ?>" style="border-color: @if ($errors->get('repassword')) {{ '#e74c3c' }} @endif">
								<label style="color: red;">@if ($errors->get('repassword'))
									@foreach ($errors->get('repassword') as $error)
									{{ $error }}
									@endforeach
								@endif</label>
							</div>


							

							<div class="card-footer">

								<button type="submit" name="submit" class="btn btn-primary">{{ trans('app.Submit') }}</button>
								<button type="button" name="back" onClick="javascript:history.go(-1);" class="btn btn-secondary"><i
									class="fa fa-chevron-circle-left"> &nbsp;</i>{{ trans('app.Back') }}
								</button>
							</div>
						</div>
					</div>
			</div>
		</div>
	</form>
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

	function check_address(value)
	{
		alert(value);
	}

$(function () {
	$(".select2").select2();
});
</script>
