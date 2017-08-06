<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>JournoFeed Collector</title>

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    </head>
    <body>
        <div id="app">
            <nav class="navbar navbar-default navbar-static-top">
                <div class="container">
                    <div class="navbar-header">

                        <!-- Collapsed Hamburger -->
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                            <span class="sr-only">Toggle Navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>

                        <!-- Branding Image -->
                        <a class="navbar-brand" href="{{ url('/') }}">JournoFeed Collector</a>
                    </div>

                    <div class="collapse navbar-collapse" id="app-navbar-collapse">
                        <!-- Left Side Of Navbar -->
                        <ul class="nav navbar-nav">
                            &nbsp;
                        </ul>

                        <!-- Right Side Of Navbar -->
                        <ul class="nav navbar-nav navbar-right">
                            <!-- Links -->
                            <li><a href="{{ url('articles/collect') }}">Collect Articles</a></li>
                            <li><a href="{{ url('articles/not-actioned') }}">Not Actioned Articles</a></li>
                            <li><a href="{{ url('articles/actioned') }}">Actioned Articles</a></li>
                            <li><a href="{{ url('collections/history') }}">Collection History</a></li>
                        </ul>
                    </div>
                </div>
            </nav>
            
            <!-- Alerts -->
            <div class="container">
                <div class="row">
                    <div class="col-xs-12">
                        @if(Session::get('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Error!</strong> {{Session::get('error')}}
                        </div>
                        @endif 

                        @if(Session::get('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            <strong>Success!</strong> {{Session::get('success')}}
                        </div>
                        @endif 
                    </div>
                </div>
            </div>
            
            @yield('content')
            
            <div class="container text-center text-muted">Copyright &copy; Hasan Tareque - {{date('Y')}}</div>
        </div>

        <!-- Scripts -->
        <script src="{{ asset('js/app.js') }}"></script>
        <script src="{{ asset('js/script.js') }}"></script>

    </body>
</html>
