@extends('layouts.app')

@section('content')
	<div class="col-md-6 offset-md-3">
		<form method="post" action="{{ url('update-schedule') }}">
			{{ csrf_field() }}
			<div class="card">
			  <div class="card-header">
					Edit Schedule
			  </div>
			  <div class="card-body">
					<div class="form-group">
						<label for="destination">Destination</label>
						<input type="text" list="destination_option" name="destination" value="{{ $sched->destination }}" id="destination" class="form-control">
						<datalist id="destination_option">


						</datalist>
					</div>
					<div class="form-group">
						<label for="details">Details</label>
						<textarea name="details" id="details" class="form-control">{{ $sched->details }}</textarea>
					</div>
					<div class="form-group">
						<div class="row">
							<div class="col-md-6">
								<label for="checkin">Check In</label>
								<input type="datetime-local" class="form-control" name="checkin" id="checkin" value="{{ ($sched->planned_date)->format('m-d-Y h:i a') }}">
							</div>
							<div class="col-md-6">
								<label for="checkout">Check Out</label>
								<input type="datetime-local" class="form-control" name="checkout" id="checkin" value="{{ ($sched->planned_date)->format('m-d-Y h:i a') }}">
							</div>
						</div>
					</div>
			  </div>
			  <input type="hidden" name="schedule_id" value="{{ $sched->id }}">
			  <div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<a href="{{ route('schedule') }}" class="btn btn-secondary" data-dismiss="modal">Close</a>

		</form>
	</div>

@endsection
