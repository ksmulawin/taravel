@extends('layouts.app')

@section('content')
	<div class="col-md-6 offset-md-3">
		<form method="post" action="{{ url('edit-bucket') }}">
			{{ csrf_field() }}
			<div class="card">
			  <div class="card-header">
					Edit Destination
			  </div>
			  <div class="card-body">
				<div class="form-group">
					<label for="destination">Destination</label>
					<input type="text" name="destination" value="{{ $bucket->destination }}" id="destination" class="form-control">
				</div>
				<div class="form-group">
					<label for="details">Details</label>
					<textarea name="details" id="details" class="form-control">{{ $bucket->details }}</textarea>
				</div>
			  </div>
			  <input type="hidden" name="bucket_id" value="{{ $bucket->id }}">
			  <div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<a href="{{ route('bucket') }}" class="btn btn-secondary" data-dismiss="modal">Close</a>

		</form>
	</div>

@endsection