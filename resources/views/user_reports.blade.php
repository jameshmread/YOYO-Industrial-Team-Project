@extends('layouts.app')

@section('title', 'Manage and generate reports')

@section('content')
    <div class="container">
        <div class="panel panel-body">
        <div class="row">
            <div class="col-md-12">
                <h1 class="panel">@yield('title')</h1>
                <hr>
            </div>
        </div>
            <reports :stores="{{json_encode(Auth::user()->GetRights())}}" :userid="{{Auth::user()->id}}"></reports>
    </div>
    </div>
@endsection