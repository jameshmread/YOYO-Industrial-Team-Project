@extends('layouts.angular')
@section('content')
<div class="container">
    <title>YOYOAngular</title>
    <base href="/">

    <link rel="icon" type="image/x-icon" href="favicon.ico">
    </head>
    <app-root>
        <script src="{{ asset('js/Chart.bundle.js') }}"></script>
    </app-root>
</div>
@endsection()