@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">Bucket List</div>
                <div class="card-body">
					<div class="float-right">
						<button class="btn btn-primary" data-toggle="modal" data-target="#bucket-modal"> Add New</button>
					</div>
					<div class="clearfix"></div>
					<br/>
					<table class="table">
						<thead>
							<tr class="thead-dark">
								<th>Destination</th>
								<th class="text-center">Action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($bucket as $each)
							<tr>
								<td>
									{{ $each->destination }} -- <small><i>{{ $each->details }}</i></small>
								</td>
								<td class="text-center">
									<a  href="{{ url('edit-bucket/'.$each->id) }}" class="btn btn-success btn-sm">Edit</a>
									 <a href="{{ url('delete-bucket/'.$each->id) }}">
                                        <input type="button" class="btn btn-danger btn-sm" value="Remove" onclick="if (!confirm('Are you sure to remove this destination?')) return false;">
                                    </a>
								</td>
							</tr>
							@endforeach
						</tbody>
					</table>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="bucket-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<form method="post" action="{{ url('add-bucket') }}">
			{{ csrf_field() }}
			<div class="modal-content">
			  <div class="modal-header">
				<h5 class="modal-title">New Destination</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				  <span aria-hidden="true">&times;</span>
				</button>
			  </div>
			  <div class="modal-body">
				<div class="form-group">
					<label for="destination">Destination</label>
					<input type="text" name="destination" id="destination" class="form-control">
				</div>
				<div class="form-group">
					<label for="details">Details</label>
					<textarea name="details" id="details" class="form-control"></textarea>
				</div>
			  </div>
			  <div class="modal-footer">
				<button type="submit" class="btn btn-primary">Save changes</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
			  </div>
			</div>
		</form>
	</div>
</div>

<script>
  $(function(){
    $('#destination').focus(function(){
      $('.pac-container').css('z-index','99999');
    });
  });

    $(function(){
        autoCompleteLocation();
    })
  
</script>

    <style>
    .modal{
      z-index: 20;
    }
    .modal-backdrop{
      z-index: 10;
    }​
    </style>
@endsection
