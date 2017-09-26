@extends('layouts.app')

@section('title', 'Manage and generate reports')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>@yield('title')</h1>
                <hr>
            </div>
        </div>

        <reports :stores="{{json_encode($user_rights)}}" :userid="{{Auth::user()->id}}"></reports>
    </div>
@endsection