@if (Session::has('error-message'))
<div class="alert alert-danger alert-dismissible">
	<h4><i class="icon fa fa-ban"></i> {{ Session::get('error-message') }}</h4>
</div>
@endif