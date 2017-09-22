@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>User Volume per Store</h1>
        <div class="row">
            <div class="col-md-6">
                <uservolumeperstorebarchart></uservolumeperstorebarchart>
            </div>

            <div class="col-md-6">
                <uservolumeperstorepiechart></uservolumeperstorepiechart>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <uservolumeperstorelinechart></uservolumeperstorelinechart>
            </div>
        </div>
    </div>
@endsection