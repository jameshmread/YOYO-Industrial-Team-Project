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
                                    <dd class="col-sm-7"> £{{$recentTransactions}}</dd>

                                    <dt class="col-sm-5">Number of Unique Users</dt>
                                    <dd class="col-sm-7"> {{$recentCustomerVolume}}</dd>
                                </dl>
                            </div>
                       </div>
                       <div class="col-md-6">
                           <div class="panel-heading">This Month</div>
                            <div class="panel-body ">
                                <dl class="row">
                                    <dt class="col-sm-5">Sales</dt>
                                    <dd class="col-sm-7"> £{{$recentTransactions}}</dd>

                                    <dt class="col-sm-5">Number of Unique Users</dt>
                                    <dd class="col-sm-7"> {{$recentCustomerVolume}}</dd>
                                </dl>
                            </div>
                       </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
