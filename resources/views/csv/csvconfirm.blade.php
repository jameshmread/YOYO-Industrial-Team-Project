@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="panel panel-default">
            <div style="padding: 5px">
                <div style="text-align: center">
                    <h1 class="panel panel-heading panel-info">CSV Uploaded Successfully!</h1>
                </div>
            </div>
            <div style="padding-bottom: 5px">
                <div style="text-align: center;">
                    @if(Auth::user()->is_admin === 1)
                        <form action="{{route('admin.dashboard')}}" method="GET">
                            <button type="submit" class="btn btn-primary btn-lg">Back</button>
                        </form>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection