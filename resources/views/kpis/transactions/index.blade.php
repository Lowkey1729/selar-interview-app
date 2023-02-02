@forelse($transactions as $transaction)
    <p>{{$transaction['currency']}}</p>
    <p>{{$transaction['total_amount_of_sales']}}</p>
    <p>{{number_format($transaction['profits'], 2)}}</p>
@empty
    <p>No sales</p>
@endforelse

<form method="GET" action="{{route('transactions.kpi.volume')}}">
    @csrf
    <label>
        <select name="currency">
            <option value="ALL">ALL Currencies</option>
            @foreach($currencies as $currency)
                <option
                    {{request()->input('currency') == $currency['code'] ? 'selected' : '' }}

                        value="{{$currency['code']}}">

                    {{$currency['name']}}

                </option>
            @endforeach

        </select>
    </label>

    <h1>From</h1>
    <label>
        <input type="date" name="date[from]">
    </label>

    <h1>To</h1>
    <label>
        <input type="date" name="date[to]">
    </label>

    <button type="submit">Filter</button>
</form>
