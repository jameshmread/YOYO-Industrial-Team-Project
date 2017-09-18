@extends('layouts.app')

@section('title', $page_details['title'])

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>{{ $page_details['pagetitle'] }}</h1>
                <hr>

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

            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <form action="{{ $page_details['route'] }}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}
                    {{ method_field($page_details['methodtype']) }}

                    <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                               placeholder="{{$user->name}}"
                               value="{{ Request::old('name', $user->name) }}">
                    </div>

                    <div class="form-group{{ $errors->has('email') ? ' has-error' : '' }}">
                        <label for="email">Email</label>
                        <input type="email" class="form-control" id="email" name="email"
                               placeholder="{{$user->email}}"
                               value="{{ Request::old('email', $user->email) }}">
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                               placeholder="Password">
                    </div>

                    <div class="form-group{{ $errors->has('password') ? ' has-error' : '' }}">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                               name="password_confirmation"
                               placeholder="Confirm Password">
                    </div>

                    <div class="form-check">
                        <label class="form-check-label">
                            <input type="checkbox"
                                   class="form-check-input"
                                   name="admin"
                                   value="{{ Request::old('admin', '1')}}"
                                    {{ $user->is_admin == true ? 'checked' : '' }}>
                            Admin
                        </label>
                    </div>

                    <div class="row">
                        <div class="col-md-4">
                            <h3>Rights to view:</h3>

                            <select class="urights form-control" name="rights[]" multiple>
                                @foreach ($user_rights as $key => $label)
                                    @if ($key != 'old')
                                        <option value="{{ Request::old($key, $key) }}"
                                                {{ $user->$key == true ? 'selected' : '' }}>
                                            {{ $label }}
                                        </option>
                                    @endif
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <br>

                    <div class="form-group">
                        <button type="submit" class="btn btn-primary">{{ $page_details['button'] }}</button>
                    </div>

                </form>
            </div>
        </div>
    </div>
@endsection