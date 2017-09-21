@extends('layouts.app')

@section('content')

    <div class="container">
        <h1>User Spending Path</h1>
        <div class="row">
            <div class="col-md-6">
                <userspendingpathbarchart></userspendingpathbarchart>
            </div>

            <div class="col-md-6">
                <userspendingpathpiechart></userspendingpathpiechart>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <userspendingpathlinechart></userspendingpathlinechart>
            </div>
        </div>
    </div>
@endsection