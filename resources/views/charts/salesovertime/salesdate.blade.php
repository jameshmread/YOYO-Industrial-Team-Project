@extends('layouts.app')

@section('content')
<sales-over-time-against-stores :stores="{{ json_encode(Auth::user()->GetRights()) }}">
</sales-over-time-against-stores>
@endsection