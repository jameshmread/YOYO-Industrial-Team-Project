@extends('layouts.app')

@section('content')
    <div class="container">
        <h1 class="col-md-6" style="font-size: x-large">
            <div class="row">Last Month</div>
            <div class="row">{{$lastMonthStart}} - {{$lastMonthEnd}}</div>
        </h1>
        <h1 class="col-md-6" style="text-align: right; font-size: x-large">
            <div class="row">This Month</div>
            <div class="row">{{$startOfThisMonth}} - {{$currentDate}}</div>
        </h1>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Combined Sales Statistics for All Stores</div>
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

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">User Statistics</div>
                    <div class="panel-body">
                        <div class="container">
                            <div class="col-md-6">
                                <div class="panel-body">
                                    <dl class="row">
                                        <dt class="col-sm-6 display-1">Number of Unique Users</dt>
                                        <dd class="col-sm-6 display-1"> {{$customerVolume}}</dd>
                                    </dl>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="panel-group" id="accordion">
            <div class="panel panel-info">
                <div class="panel-heading">
                    <div class="col-sm-3">Individual Store Breakdown</div>
                    <div class="col-md-offset-11">
                        <div class="glyphicon glyphicon-menu-hamburger"
                             data-toggle="collapse"
                             data-parent="#accordion"
                             href="#collapse1">
                        </div>
                    </div>
                </div>
                <div class="panel panel-body">
                    <div id="collapse1" class="panel-collapse collapse out" style="padding: 10px">
                        @for($i = 0; $i < sizeof($rights); $i++)
                            <div class="row panel panel-default">
                                <div class="panel panel-heading">{{$rights[$i]}}</div>
                                <div class="col-md-6">
                                    <div class="panel-heading">Last Month</div>
                                    <dl class="row">
                                        <dt class="col-sm-5" style="padding-left: 30px">Sales</dt>
                                        <dd class="col-sm-7"> £{{$managersStoreSalesPrevious[$i]}}</dd>
                                    </dl>
                                </div>
                                <div class="col-md-6">
                                    <div class="panel-heading">This Month</div>
                                    <dl class="row">
                                        <dt class="col-sm-5" style="padding-left: 30px">Sales</dt>
                                        <dd class="col-sm-7"> £{{$managersStoreSalesCurrent[$i]}}</dd>
                                    </dl>
                                    <dl class="row">
                                        <dt class="col-sm-5" style="padding-left: 30px">Difference</dt>
                                        @if($multiStoresSalesDifference[$i] > 0)
                                            <dd class="col-sm-7 green"> + £{{$multiStoresSalesDifference[$i]}}</dd>
                                        @else
                                            <dd class="col-sm-7 red"> - £{{$multiStoresSalesDifference[$i]}}</dd>
                                        @endif
                                    </dl>
                                </div>
                            </div>
                            <br>
                        @endfor
                    </div>

                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
