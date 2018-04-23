@extends('layouts.app')

@section('content')
	<div class="col-md-6 offset-md-3">
		<form method="post" action="{{ url('edit-story') }}">
			{{ csrf_field() }}
			<div class="card">
			  <div class="card-header">
					Share your story
			  </div>
			  <div class="card-body">
					<h3>{{ $trips->destination }}</h3>
					<div class="form-group">
						<label for="destination">Create your story</label>
						<textarea class="form-control" name="story" rows="10" required>{{ $trips->story }}</textarea>
					</div>
			  </div>
			  <div class="modal-footer">
						<input type="hidden" name="trip_id" value="{{ $trips->id }}">
						<button type="submit" class="btn btn-primary">Save changes</button>
						<a href="{{ route('trips') }}" class="btn btn-secondary" data-dismiss="modal">Close</a>

		</form>
	</div>

@endsection
