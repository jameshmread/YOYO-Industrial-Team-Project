@extends('layouts.app')

@section('content');


<form action="/linechart" method = "GET">
    <input type ="submit" value = "Line Chart" />
</form>

<form action="/piechart" method = "GET">
    <input type ="submit" value = "Pie Chart" />
</form>

<form action="/barchart" method = "GET">
    <input type ="submit" value = "Bar Chart" />
</form>

@endsection