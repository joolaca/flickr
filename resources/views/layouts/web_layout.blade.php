<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="format-detection" content="telephone=no"/>
    <link rel="icon" href="images/favicon.ico" type="image/x-icon">
    <title>{{ config('app.name', 'Joó László') }}</title>


    <!-- Links -->
    <link href="{{ url('css/bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ url('css/style.css') }}" rel="stylesheet" type="text/css" />


</head>
<body >

    <!--========================================================
                              HEADER
    =========================================================-->
    <header>
        @include('menu')
    </header>

    <!--========================================================
                              CONTENT
    =========================================================-->

    <main role="main">

        @yield('content')

    </main>

    <!--========================================================
                            FOOTER
  =========================================================-->
    <footer>
        <div class="container">

        </div>
    </footer>


<!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
<!-- Include all compiled plugins (below), or include individual files as needed -->


<!-- </script> -->

<script src="{{ url('/js/bootstrap.js') }}" type="text/javascript"></script>
<script src="{{ url('/js/frontend.min.js') }}" type="text/javascript"></script>

    <!-- </script>
    /*---------------------------
    * Ezeket bele kell tenni a gruntfile js fájba
    *---------------------------*/
    -->
<script src="{{ url('/js/frontend/flickr.js') }}" type="text/javascript"></script>
<script src="{{ url('/js/assets/modal.js') }}" type="text/javascript"></script>


@stack('script_src')


</body>
</html>
