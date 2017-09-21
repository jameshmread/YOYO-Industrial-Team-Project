@extends('layouts.app')

@section('title', 'Edit Your Profile')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>@yield('title')</h1>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">

                @if(count($errors))
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

            </div>
        </div>

        <div class="row">
            <div class="col-md-4">
                <form action="{{ route('user.update', Auth::user()->id) }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="{{$user->name}}"
                               value="{{ Request::old('name', $user->name) }}">
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Name</label>
                        <input type="text" class="form-control" id="email" name="email"
                               placeholder="{{$user->email}}"
                               value="{{ Request::old('email', $user->email) }}">
                    </div>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">Update Profile</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection
