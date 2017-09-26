@extends('layouts.app')

@section('title', 'Admin User Panel')

@section('content')
    <div class="container">
        @if (Session::has('success'))
            <p class="alert alert-success">{{ Session::get('success') }}</p>
        @endif
    </div>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel-heading h1">@yield('title')</div>
                <div class="col-md-offset-1">
                    <form action="{{route('admin.users.create')}}" method="GET">
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </form>
                </div>
                <div class="panel-body ">
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
                                        <a class="btn btn-warning" href="{{ route('admin.users.edit', $user->id) }}">Edit</a>
                                    </td>

                                    <td width="20%">

                                        <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}
                                            @if ($user->is_admin == 1)
                                            <button
                                                    type="submit"
                                                    class="btn btn-danger"
                                                    title="Admin users cannot be deleted. Contact an Administrator."
                                                    disabled>Delete</button>
                                            @else
                                                <button type="submit" class="btn btn-danger">Delete</button>
                                            @endif
                                        </form>
                                    </td>

                                </tr>
                            @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>

@endsection