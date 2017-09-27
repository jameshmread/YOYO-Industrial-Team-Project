@extends('layouts.app');

@section('content')
<user-retention :stores="{{ json_encode(Auth::user()->GetRights()) }}"></user-retention>
@endsection