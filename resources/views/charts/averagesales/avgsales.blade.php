@extends('layouts.app')

@section('content')
    <avg-sales-over-time :stores="{{ json_encode(Auth::user()->GetRights()) }}"></<avg-sales-over-time>
@endsection