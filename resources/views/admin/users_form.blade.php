@extends('layouts.app')

@section('title', $page_details['title'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $page_details['pagetitle'] }}</h1>
                <hr>

                <div class="row">

                    <div class="col-md-12">

                        @if(count($errors))
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ $page_details['route'] }}" method="POST" enctype="multipart/form-data">
                            {{ csrf_field() }}
                            {{ method_field($page_details['methodtype']) }}

                            <div class="row">

                                <div class="form-group col-md-5{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="name">Name</label>
                                    <input type="text" class="form-control" id="name" name="name"
                                           placeholder="{{$user->name}}"
                                           value="{{ Request::old('name', $user->name) }}">
                                </div>

                                <div class="form-group col-md-5{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="emailField">Email</label>
                                    <input type="email" class="form-control" id="emailField" name="email"
                                           placeholder="{{$user->email}}"
                                           value="{{ Request::old('email', $user->email) }}">
                                </div>

                            </div>
                            <div class="row">
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="passwordField">Password</label>
                                    <input type="password" class="form-control" id="passwordField" name="password"
                                           placeholder="Password">
                                </div>
                                <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                    <label for="password_confirmation">Confirm Password</label>
                                    <input type="password" class="form-control" id="password_confirmation" name="password_confirmation"
                                           placeholder="Confirm Password">
                                </div>

                                <div class="form-group">
                                    <label for="is-admin" class="col-md-4 control-label">Admin Privileges</label>

                                    <div class="col-md-1">
                                        <input id="is_admin" type="hidden" class="form-control" name="is_admin"
                                               value="0">
                                        <input id="is_admin" type="checkbox" class="form-control" name="is_admin"
                                               value="1">
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group">
                                    <button type="submit" class="btn btn-primary">{{ $page_details['button'] }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection