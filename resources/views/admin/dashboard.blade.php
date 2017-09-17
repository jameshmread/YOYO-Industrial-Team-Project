@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>@yield('title')</h1>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-3">
                <form action="{{route('admin.users.index')}}" method="GET">
                    <button type="submit" class="btn btn-primary">Users Panel</button>
                </form>
            </div>

            <div class="col-md-3">
                <form action="{{route('admin.upload.index')}}" method="GET">
                    <button type="submit" class="btn btn-primary">Upload CSV File</button>
                </form>
            </div>
        </div>
    </div>


@endsection