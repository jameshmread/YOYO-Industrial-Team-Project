@extends('layouts.app')

@section('content')
<div class="container">
<h1> {{ $user->name }}</h1>
<h2> {{ $user->email }}</h2>

<p> Edit details </p>

<form action="/users" method="POST">

{{ csrf_field() }}
  Name:<br>
  <input type="text" id="name" name="name" 
  placeholder="{{$user->name}}"
  value="{{ Request::old('name', $user->name) }}"><br>

  <input type="text" id="email" name="email" 
  placeholder="{{$user->email}}"
  value="{{ Request::old('email', $user->email) }}"><br>
  
  <input type="hidden" id="id" name="id" 
  placeholder="{{$user->id}}"
  value="{{ Request::old('id', $user->id) }}">
  <input type="submit" value="Submit" >
</form>
</div>
@endsection
