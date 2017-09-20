@extends('layouts.app');

@section('content');
<div id="app">
    <?php echo Config::get('constants.colours.blue') ?>
    <linechart></linechart>

</div>

@endsection