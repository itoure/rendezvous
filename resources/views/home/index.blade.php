@extends('app')

@section('content')

<div class="row">
    <div class="col-md-offset-1 col-md-10">
        <div id="alerts">
            @if (session('welcome'))
            <div id="welcome-alert" class="alert alert-success" role="alert">Welcome to Nabantoo <a class="alert-link" href="{{action('UserController@getAccount')}}">{{$data->user_firstname}}</a> !</div>
            @endif

            @if (session('welcome_back'))
            <div id="welcomeback-alert" class="alert alert-success" role="alert">Welcome back <a class="alert-link" href="{{action('UserController@getAccount')}}">{{$data->user_firstname}}</a> !</div>
            @endif
        </div>

        <div id="filters">
            <button type="button" class="btn btn-default btn-sm" data-filter="*">{{trans('messages.all')}}</button>
            <button type="button" class="btn btn-default btn-sm" data-filter=".fitToMe">{{trans('messages.fit_to_me')}}</button>
            <button type="button" class="btn btn-default btn-sm" data-filter=".aroundMe">{{trans('messages.around_me')}}</button>
            <button type="button" class="btn btn-default btn-sm" data-filter=".aroundMe.fitToMe">{{trans('messages.exact_match')}}</button>
            <button type="button" class="btn btn-default btn-sm" data-filter=".aroundMe.fitToMe">My Network</button>
            <button type="button" class="btn btn-default btn-sm" data-filter=".aroundMe.fitToMe">My Events</button>
        </div>
    </div>
</div>

<div class="row top20">
    <div class="col-md-offset-1 col-md-7">

        <ul class="list-group" id="">
            @foreach ($data->events as $event)
            <li class="list-group-item event_id_{{ $event->eve_id }} event-item {{ $event->fitToMe ? 'fitToMe' : '' }} {{ $event->aroundMe ? 'aroundMe' : '' }}">
                <div class="container-fluid">
                    <div class="row row-list">
                        <div class="col-xs-3 col-sm-3 col-md-3">
                            @if (!empty($event->eve_photo))
                            {!! Html::image('img/interests/'.$event->eve_photo, '', array('class' => 'img-event-item')) !!}
                            @else
                            <img class="" src="holder.js/100px98?text={{ $event->int_name }}&theme={{$event->cat_color}}" alt="">
                            @endif
                        </div>
                        <div class="col-xs-9 col-sm-9 col-md-9">
                            <h5 class="list-group-item-heading marg-top5">
                                <a href="{{action('EventController@getDetails', array('event_id'=> $event->eve_id))}}">
                                    {{ $event->eve_title }}
                                </a>
                            </h5>
                            <p>
                                <i class="fa fa-calendar"></i> <small>{{ $event->eve_start_date }}</small> |
                                <i class="fa fa-map-marker text-danger"></i> <small>{{ $event->short_locality }}</small> |
                                <i class="fa fa-users text-success"></i> <small>{{ $event->count_people }}</small>
                            </p>
                            <p class="marg-bot5">
                                @if (!empty($event->usr_photo))
                                {!! Html::image('files/user/'.$event->usr_photo, '', array('class' => 'img-user30 img-rounded')) !!}
                                @else
                                <img class="img-circle" src="holder.js/30x30?text={{ $event->usr_first_letter }}" alt="">
                                @endif
                                <a href="{{action('UserController@getProfile', array('user_id'=> $event->usr_id))}}" class="small">{{ $event->usr_firstname }}</a>

                                <span id="info-item-list" class="pull-right">
                                    <i id="join-loading" class="fa fa-spinner fa-spin" style="display: none"></i>
                                    <a role="button" href="#" class="btn btn-default btn-xs join-event" data-event-id="{{ $event->eve_id }}"><i class="fa fa-user-plus"></i> {{trans('messages.join')}}</a>
                                    <a role="button" href="#" class="btn btn-default btn-xs" data-event-id="{{ $event->eve_id }}"><i class="fa fa-user-times"></i> decline</a>
                                </span>
                            </p>
                        </div>

                    </div>
                </div>
            </li>
            @endforeach
        </ul>

        <h4>Past Events Highlights</h4>
        <div class="row">
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="holder.js/100px100?text={{ $event->usr_first_letter }}" alt="">
                    <div class="caption">
                        <h3>Thumbnail label</h3>
                        <p>...</p>
                        <p><a href="#" class="btn btn-primary" role="button">Button</a></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="holder.js/100px100?text={{ $event->usr_first_letter }}" alt="">
                    <div class="caption">
                        <h3>Thumbnail label</h3>
                        <p>...</p>
                        <p><a href="#" class="btn btn-primary" role="button">Button</a></p>
                    </div>
                </div>
            </div>
            <div class="col-sm-6 col-md-4">
                <div class="thumbnail">
                    <img src="holder.js/100px100?text={{ $event->usr_first_letter }}" alt="">
                    <div class="caption">
                        <h3>Thumbnail label</h3>
                        <p>...</p>
                        <p><a href="#" class="btn btn-primary" role="button">Button</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-3">
        <div class="panel panel-default">
            <div class="panel-heading">My next events</div>
            <div id="myNextEvents-loading" class="text-center top20">
                <i class="fa fa-spinner fa-spin fa-2x"></i>
            </div>
            <div id="myNextEvents" class="panel-body">

            </div>
        </div>

    </div>

</div>


@endsection
