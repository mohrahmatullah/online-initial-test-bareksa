@if (Session::has('success-message'))
<div class="card">
	<div class="card-body">
		<div class="sufee-alert alert with-close alert-success alert-dismissible fade show">
		    {{ Session::get('success-message') }}
		    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
		        <span aria-hidden="true">&times;</span>
		    </button>
		</div>
	</div>
</div>
@endif