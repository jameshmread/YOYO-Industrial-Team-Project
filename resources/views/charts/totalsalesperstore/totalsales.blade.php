@extends('layouts.app');

@section('content');
<total v-bind:stores="{{json_encode(Auth::user()->GetRights())}}">
</total>

@endsection