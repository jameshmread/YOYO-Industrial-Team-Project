@extends('layouts.app');

@section('content');
<sales-over-time-against-stores v-bind:store="{{json_encode(Auth::user()->GetRights())}}">
</sales-over-time-against-stores>

@endsection