@extends('layouts.app')

@section('content')
<script>
	$(function(){
		$('#destination').change(function(){
			var that = $(this);
			$('#details').html('');
			$('#destination_option option').each(function(){
				if($(this).val() == that.val())
				{
					$('#details').html($(this).attr('data-details'));
				}
			});
		});

	});
</script>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Schedule</div>
                <div class="card-body">
									<div class="float-left">
										<button class="btn btn-info map" id="change-view"> Display On Map</button>
									</div>
									<div class="float-right">
										<button class="btn btn-primary" data-toggle="modal" data-target="#schedule-modal"> Add New</button>
									</div>
									<div class="clearfix"></div>
									<br/>
									<table class="table sched-table">
										<thead>
											<tr class="thead-dark">
												<th>Destination</th>
												<th>Details</th>
												<th>Planned Date</th>
												<th>Checkout Date</th>
												<th>Status</th>
												<th class="text-center">Action</th>
											</tr>
										</thead>
										<tbody class="schedule-body">
											@foreach($schedule as $sch)
												<tr>
													<td>{{ $sch->destination }}</td>
													<td>{{ $sch->details }}</td>
													<td>{{ $sch->planned_date->format('M d, Y h:i a') }}</td>
													<td>{{ $sch->checkout_date->format('M d, Y h:i a') }}</td>
													<td>{{ ucfirst($sch->status) }}</td>
													<td class="text-center">
														@if($sch->status != 'colored')
															<a  href="{{ url('color-schedule/'.$sch->id) }}" class="btn btn-info btn-sm">Colored</a>
														@endif
														<a  href="{{ url('edit-schedule/'.$sch->id) }}" class="btn btn-success btn-sm">Edit</a>
														 <a href="{{ url('remove-schedule/'.$sch->id) }}">
															<input type="button" class="btn btn-danger btn-sm" value="Remove" onclick="if (!confirm('Are you sure to remove this schedule?')) return false;">
														</a>
													</td>
												</tr>
											@endforeach
										</tbody>
									</table>
									 <div id="map" style="height:720px;display:none"></div>
									 <style>
									 	#map
										{
											width:100%;
										}
									 </style>
									<script>
										var marker,infowindow,map;


										$(function(){
											$('#change-view').click(function(){
													var that = $(this);
													that.text('View On Table');
													if(that.hasClass('map'))
													{
														that.removeClass('map');
														$('.sched-table').fadeOut();
														$('#map').css('display','block');
													}
													else
													{
														$('#map').css('display','none');
														$('.sched-table').fadeIn();
														that.addClass('map')
													}
											});

												map = new google.maps.Map(document.getElementById('map'), {
																		 zoom: 6,
																		 center: new google.maps.LatLng(12.8797, 121.7740),
																		 mapTypeId: google.maps.MapTypeId.ROADMAP
																	 });
												 infowindow = new google.maps.InfoWindow();

												$('.schedule-body tr').each(function(i){
													var that = $(this);
													var address = that.find('td:first').html();
													var checkin = new Date(that.find('td:nth-child(3)').html());
													var checkout = that.find('td:nth-child(4)').html();
													var details = address+'<br/>'+setDate(checkin)+' to '+setDate(checkout);
													getGeoLocation(address,function(result){
															setMarker(details,result[0].geometry.location.lat(),result[0].geometry.location.lng());
													});

												});


										});

										function setDate(datetime)
										{
												var d = new Date(datetime);
												var arr = ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'];
												return arr[d.getMonth()]+' '+d.getDate()+', '+d.getFullYear();
										}
										function setMarker(details,lat,lon)
										{
												var str = {'latitude':lat,'longitude':lon};
												 marker = new google.maps.Marker({
																			 position: new google.maps.LatLng(lat, lon),
																			 map: map
												 							});
												google.maps.event.addListener(marker, 'click', (function(marker) {
									         return function() {
									           infowindow.setContent(details);
									           infowindow.open(map, marker);
									         }
									       })(marker))

										}

										function getGeoLocation(address,resultCapt)
										{
											var geocoder = new google.maps.Geocoder();
											geocoder.geocode( { 'address': address}, function(results, status) {

												if (status == google.maps.GeocoderStatus.OK) {
														resultCapt(results);
											    }
											});
										}
									</script>
                </div>
            </div>
        </div>
    </div>
</div>


<div class="modal" id="schedule-modal" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<form method="post" action="{{ url('add-schedule') }}">
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
					<input type="text" list="destination_option" name="destination" id="destination" class="form-control">
					<datalist id="destination_option">
						@foreach($bucket as $each)
							<option value="{{ $each->destination }}" data-details="{{ $each->details }}">
						@endforeach

					</datalist>
				</div>
				<div class="form-group">
					<label for="details">Details</label>
					<textarea name="details" id="details" class="form-control"></textarea>
				</div>
				<div class="form-group">
					<div class="row">
						<div class="col-md-6">
							<label for="checkin">Check In</label>
							<input type="datetime-local" class="form-control" name="checkin" id="checkin">
						</div>
						<div class="col-md-6">
							<label for="checkout">Check Out</label>
							<input type="datetime-local" class="form-control" name="checkout" id="checkin">
						</div>
					</div>
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


@endsection
