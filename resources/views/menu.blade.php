

<nav class="navbar navbar-default">
    <div class="container-fluid">
        <div class="navbar-header">
            <a class="navbar-brand" href="#">joolaca</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="{{url('/')}}">home</a></li>
            <li><a href="{{url('/my_flickr')}}">my_flickr</a></li>
            <li>
                @if(!is_null(session('read_oauth_token')))
                    <a href="{{url('/logout_flickr')}}">logout_flickr</a>
                @endif
            </li>
        </ul>
    </div>
</nav>