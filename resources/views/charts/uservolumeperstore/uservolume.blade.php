@extends('layouts.app')

@section('content')
    <uservolume :stores="{{ json_encode(Auth::user()->GetRights()) }}"></uservolume>
@endsection