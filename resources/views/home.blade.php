@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-default">
                <div class="panel-heading">Dashboard - Statistics</div>
                <div class="panel-body">
                   <div class="container">
                       <div class="col-md-6">
                           <div class="panel-heading">Last Month</div>
                            <div class="panel-body">
                                <dl class="row">
                                    <dt class="col-sm-5">Sales</dt>
                                    <dd class="col-sm-7"> £{{$lastMonthTransactions}}</dd>

                                </dl>
                            </div>
                       </div>
                       <div class="col-md-6">
                           <div class="panel-heading">This Month</div>
                            <div class="panel-body ">
                                <dl class="row">
                                    <dt class="col-sm-5">Sales</dt>
                                    <dd class="col-sm-7"> £{{$thisMonthTransactions}}</dd>
                                </dl>
                                <dl class="row">
                                    <dt class="col-sm-5">Difference</dt>
                                    @if($difference > 0)
                                        <dd class="col-sm-7 green"> + £{{$difference}}</dd>
                                    @else
                                        <dd class="col-sm-7 red"> - £{{$difference}}</dd>
                                    @endif
                                </dl>
                            </div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
    <d1 class="row">
        <dt class="col-sm-5 panel-heading">Number of Unique Users</dt>
        <dd class="col-sm-7 panel-body"> {{$customerVolume}}</dd>
    </d1>
</div>

@endsection
