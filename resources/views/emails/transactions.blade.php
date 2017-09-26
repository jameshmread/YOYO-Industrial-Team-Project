@component('mail::message')
# Your Months Transactions Breakdown

@component('mail::table')
|   Type    |   Cash Spent  |   Discount Amount     | Total Amount  |
|:-----------:||:-----------:||:-----------:||:-----------:|
@foreach($transactions as $transaction)
| {{$transaction->transaction_type}} | {{$transaction->cash_spent}} | {{$transaction->discount_amount}} | {{$transaction->total_amount}} |
@endforeach
@endcomponent

@endcomponent
