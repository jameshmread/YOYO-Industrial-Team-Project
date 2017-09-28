@extends('layouts.app')

@section('content')
<total :stores="{{ json_encode(Auth::user()->GetRights()) }}"></total>

@endsection