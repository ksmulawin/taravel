<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Scripts -->
    <script src="{{ asset('public/js/app.js') }}" defer></script>
    <script src="{{ asset('public/js/jquery.js') }}"></script>
    <script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?sensor=false&key=AIzaSyBZKKLMyZ5e7uLc9o1P7k2xXDUv7Nrqllw&libraries=places&callback=autoCompleteLocation"
        async ></script>
    <script>
    $(function(){
        autoCompleteLocation();
    });

    function autoCompleteLocation() {
      var input = document.getElementById('destination');
      var autocomplete = new google.maps.places.Autocomplete(input);

    }
    </script>


    <!-- Fonts -->
    <!--link rel="dns-prefetch" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css?family=Raleway:300,400,600" rel="stylesheet" type="text/css"-->

    <!-- Styles -->
    <link href="{{ asset('public/css/app.css') }}" rel="stylesheet">
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
            <div class="container-fluid">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ config('app.name', 'Laravel') }}
                </a>
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav mr-auto">
					 @guest

					 @else
						<li class="{{ (\Request::route()->getName()) == 'bucket' ? 'active' : '' }}"><a class="nav-link" href="{{ route('bucket') }}">Bucket List</a></li>
						<li  class="{{ (\Request::route()->getName()) == 'schedule' ? 'active' : '' }}"><a class="nav-link" href="{{ route('schedule') }}">Schedules</a></li>
						<li class="{{ (\Request::route()->getName()) == 'trips' ? 'active' : '' }}"><a class="nav-link" href="{{ route('trips') }}">Trip</a></li>
						<li><a class="nav-link" href="#">Gallery</a></li>
					@endguest
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ml-auto">
                        <!-- Authentication Links -->
                        @guest
                            <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                            <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    <img src="{{asset('storage/app/avatar/'. Auth::user()->avatar)}}" class="img-fluid  rounded-circle" style="width:25px"/>
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="#" data-toggle="modal" data-target="#avatarModal">
                                        {{ __('Avatar') }}
                                    </a>
                                    <a class="dropdown-item" href="{{ route('logout') }}"
                                       onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                        {{ __('Logout') }}
                                    </a>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                </div>

                            </li>
                        @endguest
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>


    <!-- The Avatar Modal -->
  <div class="modal fade" id="avatarModal">
    <div class="modal-dialog">
      <div class="modal-content">
        <form method="post" enctype="multipart/form-data" action="{{ url('changeAvatar') }}">
          {{ csrf_field() }}
          <!-- Modal Header -->
          <div class="modal-header">
            <h4 class="modal-title">Avatar</h4>
            <button type="button" class="close" data-dismiss="modal">&times;</button>
          </div>

          <!-- Modal body -->
          <div class="modal-body">
              <div class="form-group">
                <label>Upload Image :</label>
                <input type="file" name="avatar">
              </div>
          </div>

          <!-- Modal footer -->
          <div class="modal-footer">
            <button type="submit" class="btn btn-primary">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</body>
</html>
