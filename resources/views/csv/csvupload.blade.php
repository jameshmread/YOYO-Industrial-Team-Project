@extends('layouts.app')

@section('content')
    <div class="container">
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    </div>
    <div class="container">
        <div class="panel panel-default">
            <div class="panel panel-heading">CSV File Upload</div>
        <div class="panel panel-body">
            <div class="">
                <form action="{{route('admin.upload')}}" method="POST" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <div class="form-group{{$errors->has('inputFile') ? 'has-error' : ''}}">
                        <label for="inputFile">File input</label>
                        <input type="file" class="form-control-file" id="inputFile" name="inputFile" aria-describedby="fileHelp">
                        <small id="fileHelp" class="form-text text-muted"> Accepts .csv files only
                        </small>
                    </div>

                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
            </div>
        </div>
        </div>
    </div>
@endsection