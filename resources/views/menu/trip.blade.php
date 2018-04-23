@extends('layouts.app')

@section('content')

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">My Trips</div>
                <div class="card-body">
                    @foreach($trips as $each)
                    <div class="alert alert-primary" role="alert">
                       <h4 class="alert-heading">
                          {{ $each->destination }}
                          <small><i>{{ $each->checkin_date }} to {{ $each->checkout_date }} </i></small>
                       </h4>
                       <hr>
                         <pre style="white-space: pre-line!important;
                                     font-size: inherit!important;
                                     font-family: inherit!important;">
                           @if($each->story == '')
                              Want to share your journey? Click <a href="{{ url('edit-trips/'.$each->id) }}">here</a> to tell your stories.
                           @else
                            {{ $each->story }}
                           @endif
                         </pre>

                       @if($each->story != '')
                          <span class="float-right"><a href="{{ url('edit-trips/'.$each->id) }}">Edit Story</a></span>
							<div class="clearfix"></div>
                       @endif
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
