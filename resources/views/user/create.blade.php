@extends('layout')

@section('content')

<div class="row">
    <div class="col-md-offset-2 col-md-8">
        <div class="panel panel-default">
            <div class="panel-heading">Create Your Account</div>
            <div class="panel-body">


                @if(!empty($errors->any()))
                <div class="alert alert-danger" role="alert">
                    <ul>
                    <div>{{ $errors->first('firstname') }}</div>
                    <div>{{ $errors->first('sexe') }}</div>
                    <div>{{ $errors->first('month') }}</div>
                    <div>{{ $errors->first('day') }}</div>
                    <div>{{ $errors->first('year') }}</div>
                    <div>{{ $errors->first('email') }}</div>
                    <div>{{ $errors->first('password') }}</div>
                    <div>{{ $errors->first('interests') }}</div>
                    </ul>
                </div>
                @endif

                {!! Form::open(array('action' => 'UserController@postStore', 'files' => true)) !!}

                <div class="form-group">
                    {!! Form::text('firstname', null, array(
                    'placeholder' => 'Firstame',
                    'class' => 'form-control input-lg'
                    )) !!}
                    <span class="help-block">Don't forget to put your real name ;-)</span>
                </div>

                <div class="form-group">
                    {!! Form::text('search', null, array(
                    'placeholder' => 'Search',
                    'class' => 'form-control input-lg',
                    'id' => 'search_autocomplete',
                    'autocomplete' => 'off'

                    )) !!}
                </div>

                <div class="form-group">
                    {!! Form::text('locality', null, array(
                    'placeholder' => 'City',
                    'class' => 'form-control input-lg',
                    'id' => 'locality'
                    )) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('administrative_area_level_1', null, array(
                    'placeholder' => 'State',
                    'class' => 'form-control input-lg',
                    'id' => 'administrative_area_level_1'
                    )) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('postal_code', null, array(
                    'placeholder' => 'Zip Code',
                    'class' => 'form-control input-lg',
                    'id' => 'postal_code'
                    )) !!}
                </div>
                <div class="form-group">
                    {!! Form::text('country', null, array(
                    'placeholder' => 'Country',
                    'class' => 'form-control input-lg',
                    'id' => 'country'
                    )) !!}
                </div>

                <div class="form-group">
                    <label class="radio-inline">
                    {!! Form::radio('sexe', 'F') !!} Female
                    </label>

                    <label class="radio-inline">
                    {!! Form::radio('sexe', 'M') !!} Male
                    </label>
                </div>

                <h5>Birthday</h5>
                <div class="form-group">
                    {!! Form::select('month', array_combine(range(1,12),range(1,12)), '', array('class' => 'form-inline')) !!}
                    {!! Form::select('day', array_combine(range(1,31),range(1,31)), '', array('class' => 'form-inline')) !!}
                    {!! Form::select('year', array_combine(range(2015, 1915),range(2015, 1915)), '', array('class' => 'form-inline')) !!}
                </div>


                <div class="form-group">
                    {!! Form::email('email', null, array(
                    'placeholder' => 'Email',
                    'class' => 'form-control input-lg'
                    )) !!}
                </div>

                <div class="form-group">
                    {!! Form::password('password', array(
                    'placeholder' => 'Password',
                    'class' => 'form-control input-lg'
                    )) !!}
                </div>

                <h5>Your Photo</h5>
                <div class="form-group">
                    {!! Form::file('photo') !!}
                </div>

                <h3>What are your interests ?</h3>

                @foreach ($data->interests as $category => $interests)
                <div class="form-group">
                    <label class="col-md-2">{{$category}}</label>
                    @foreach ($interests as $value => $name)
                    <label class="checkbox-inline">
                        {!! Form::checkbox('interests[]', $value) !!} {{$name}}
                    </label>
                    @endforeach
                </div>
                @endforeach

                <div class="form-group">
                    {!! Form::submit('Sign Up', array(
                    'class' => 'btn btn-primary btn-lg btn-block'
                    )); !!}
                </div>

                {!! Form::close() !!}

            </div>
        </div>
    </div>
</div>

@endsection
