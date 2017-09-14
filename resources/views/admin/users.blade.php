@extends('layouts.app')

@section('title', 'Admin User Panel')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <h1>@yield('title')</h1>

                @if (Session::has('success'))
                    <p class="alert alert-success">{{ Session::get('success') }}</p>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="col-md-3">
                <form action="{{route('admin.users.create')}}" method="GET">
                    <button type="submit" class="btn btn-primary">Add User</button>
                </form>
            </div>
        </div>

        <br>

        <div class="row">
            <div class="col-md-12">
                <table class="table">
                    <tr>
                        <th>Name</th>
                        <th>Email</th>
                        <th></th>
                        <th></th>
                    </tr>

                    @foreach($users as $user)
                        <tr>

                            <td width="20%">
                                {{$user->name}}
                            </td>

                            <td width="25%"><a href="mailto:{{$user->email}}">{{$user->email}}</a></td>

                            <td width="20%">
                                <a class="btn btn-primary" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                            </td>

                            <td width="20%">
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}

                                    <button type="submit" class="btn btn-primary">Delete</button>
                                </form>
                            </td>

                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>

@endsection