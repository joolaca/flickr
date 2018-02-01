@extends('layouts.web_layout')
@section('content')
<div class="container" ng-app="MyFlickrApp">

    <div ng-controller="MyFlickerController">
        <h1>my Flickr</h1>

        <div class="row">
            @foreach($photos as $photo)
                <div class="col-md-4">
                    <img src="https://farm{{$photo['farm']}}.staticflickr.com/{{$photo['server']}}/{{$photo['id']}}_{{$photo['secret']}}_m.jpg" >
                    <md-button class="md-primary md-raised" ng-click="showEdit($event,{{$photo['id']}})"   >
                        Info
                    </md-button>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection