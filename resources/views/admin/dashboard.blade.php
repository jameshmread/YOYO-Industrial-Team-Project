@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="container">
        <div class="row">
            <div class="panel panel-default">
                <div class="panel-heading">@yield('title')</div>
                <div class="panel-body">
                    <div class="container">
                        <div class="col-md-4">
                            <form action="{{route('admin.users.index')}}" method="GET">
                                <button type="submit" class="btn btn-primary btn-lg">Users Panel</button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <form action="{{route('admin.upload.index')}}" method="GET">
                                <button type="submit" class="btn btn-primary btn-lg">Upload CSV File</button>
                            </form>
                        </div>
                        <div class="col-md-4">
                            <form action="{{route('admin.store.colour')}}" method="GET">
                                <button type="submit" class="btn btn-primary btn-lg">Change Store Colours</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection