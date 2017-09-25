@component('mail::message')
# Your Monthly Transactions Value as an Average of Gross over time

@foreach($sales as $sale)
{{$sale}}
@endforeach


@endcomponent
