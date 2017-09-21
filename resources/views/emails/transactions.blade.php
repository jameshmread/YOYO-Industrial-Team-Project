@component('mail::message')
# Transactions reports

@component('mail::table')
| Store ID       | Type         | Total Cost  |
|:-------------:|:-------------:| --------:|
@foreach($transactions as $transaction)
| {{$transaction->store_id}} | {{$transaction->transaction_type}} | {{$transaction->total_amount}} |
@endforeach
@endcomponent

@endcomponent
