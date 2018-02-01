@extends('layouts.web_layout')
@section('content')



    <div ng-app="FlickrApp" class="container">
        <div ng-controller="FlickrContentCtrl as ctrl" class="row">
            <div class="col-md-2 no-float">
                @include('flickr/search_keywords')
            </div>

            <div class="col-md-10 ">
                <flickr-images ng-repeat="item in ctrl.content" content="item"></flickr-images>
            </div>

        </div>
    </div>





@endsection