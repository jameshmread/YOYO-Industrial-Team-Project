@extends('layouts.app')

@section('content')
<unique-users :stores="{{ json_encode(Auth::user()->GetRights()) }}">
</unique-users>
@endsection