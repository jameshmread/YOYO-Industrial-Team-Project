@extends('layouts.app')

@section('content')
    <div class="container">

        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-default">
                    <div class="panel-heading">Home - Sales Statistics</div>
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

                                    @foreach($managersStoreSalesPrevious as $previousSale)
                                        <d1 class="row">
                                            {{$previousSale}}
                                        </d1>
                                    @endforeach
                                    <d1 class="row">
                                        @foreach($managersStoreSalesCurrent as $currentSale)
                                            {{$currentSale}}
                                        @endforeach
                                    </d1>
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
                    <div class="panel-heading">Home - User Statistics</div>
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
            <div class="panel panel-default">
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
                <div id="collapse1" class="panel-collapse collapse in">

                        @for($i = 0; $i < sizeof($rights); $i++)
                            <div class="container">
                                <div class="row">
                                    <div class="panel panel-default">
                                        <div class="panel-heading">{{$rights[$i]}}</div>
                                        <div class="panel-body">
                                            <div class="col-md-6">
                                                Previous
                                                {{$managersStoreSalesPrevious[$i]}}

                                            </div>
                                            <div class="col-md-6">
                                                Current
                                                {{$managersStoreSalesCurrent[$i]}}
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        @endfor
                    </div>
            </div>
            </div>
        </div>
    </div>
@endsection
