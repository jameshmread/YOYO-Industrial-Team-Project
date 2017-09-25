@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <h1>CSV Uploaded Successfully!</h1>
                
                
            </div>
        </div>
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                @if(Auth::user()->is_admin === 1)
                <form action="{{route('admin.dashboard')}}" method="GET">
                    <button type="submit" class="btn btn-primary">Back</button>
                </form>
                @endif
                
                
            </div>
        </div>
    </div>
@endsection