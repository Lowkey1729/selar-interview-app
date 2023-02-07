@extends('layouts.main')

@section('content')

    <div class="my-8 pl-2">
        <div>

            @if(request()->hasAny(['date.to', 'date.from']))
                <h2 class="my-4 font-medium">Transaction KPIs for
                    <b>{{request()->input('date.from') ." To ".  request()->input('date.to')}}</b></h2>
            @else
                <h2 class="my-4 font-medium">Transaction KPIs for the month of <b>{{date('F')}}</b></h2>
            @endif

            @if(request()->hasAny(['currency', 'date.to', 'date.from']))
                <a href="{{route('transactions.kpi.index')}}" class="max-w-lg flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Reset Filter
                </a>
            @endif
        </div>


        <div class="bg-white shadow-md  w-full sm:rounded-lg sm:overflow-hidden">
            <div class="px-1 pb-8 pt-6">
                <div class="mt-4  p-1 pt-0">
                    <form class="space-y-6" method="GET" action="{{route('transactions.kpi.volume')}}">
                        @csrf
                        <div class="grid grid-cols-2 space-x-2">
                            <div class="ml-2">
                                <x-form.label>Select Currency</x-form.label>
                                <div class="grid grid-cols-4">
                                    @foreach($currencies as $key => $currency)
                                        <div>
                                            <input type="checkbox"
                                                   name="currency[]"
                                                   {{ in_array($currency['code'], request()->input("currency")?? []) ? 'checked' : '' }}
                                                   value="{{$currency['code']}}"
                                                   class="flex  shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-lg">
                                            <label>{{$currency['name']}}</label>
                                        </div>
                                    @endforeach
                                </div>

                            </div>

                            <div>
                                <x-form.label>View From(Date)</x-form.label>
                                <x-form.input-date name="date[from]"
                                                   value="{{old('date.from') ?? request()->input('date.from')}}"></x-form.input-date>
                                @error('date.from')
                                <div class="text-red-600 bg-gray-200 p-2">{{ $message }}</div>
                                @enderror


                            </div>

                            <div>

                                <x-form.label>View To(Date)</x-form.label>
                                <x-form.input-date name="date[to]"
                                                   value="{{old('date.to') ?? request()->input('date.to')}}"></x-form.input-date>

                                @error('date.to')
                                <div class="text-red-600 bg-gray-200 p-2">{{ $message }}</div>
                                @enderror


                            </div>

                            <div class="pt-5">

                                <button type="submit"
                                        class="w-full flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                                    Filter
                                </button>
                            </div>

                        </div>


                    </form>
                </div>
            </div>
        </div>

    </div>

    <div>

        <div class="grid sm:grid-cols-3 gap-6">
            <span
                class="col-span-1 bg-sellar-100 rounded-lg hover:bg-sellar-200 md:hover:cursor-pointer transition duration-300">
            <div class="py-8 px-6">

                <div class="flex items-center justify-center">
                    <x-icons.money classs="h-5 w-5"></x-icons.money>
                    <span class="text-gray-300 text-center">All Transactions</span>
                </div>

                <div class="mt-3 mb-1 text-white font-semibold text-xl">
                   <p>Total: {{$totalTransactions}}</p>
                </div>
            </div>
        </span>

            @forelse($transactions as $transaction)
                <span
                    class="col-span-1 bg-sellar-100 rounded-lg hover:bg-sellar-200 md:hover:cursor-pointer transition duration-300">
            <div class="py-8 px-6">

                <div class="flex items-center justify-center">
                    <x-icons.money classs="h-5 w-5"></x-icons.money>
                    <span class="text-gray-300 text-center">{{currencyTitle($transaction['currency'])}}</span>
                </div>

                <div class="mt-3 mb-1 text-white font-semibold text-xl">
                   <p>Total Sales: {{$transaction['total_amount_of_sales']}}</p>
                </div>

                <div class="mt-3 mb-1 text-white font-light  text-xl">
                   <p>Total Profits: {{$transaction['currency']}} {{number_format($transaction['profits'], 2)}}</p>
                </div>

            </div>
        </span>
            @empty
                <p>No sales</p>
            @endforelse


        </div>


        <div class="mt-4">
            <h3 class="text-center text-2xl text-gray-600">Average Sales Value(Naira)</h3>
            <div class="flex mt-2  justify-center items-center gap-6">
                <div
                    class="col-span-1 w-1/2 bg-sellar-100 rounded-lg hover:bg-sellar-200 md:hover:cursor-pointer transition duration-300">
                    <span
                    >
                        <div class="py-8 px-6">
                            <div class="flex items-center justify-center justify-items-center">
                                <x-icons.money classs="h-5 w-5"></x-icons.money>
                                <span class="text-gray-300 text-xl text-center">Average Sales</span>
                            </div>

                            <div class="mt-3 mb-1 text-white font-light  text-xl">
                                <p>Value: &#8358;{{number_format(averageNairaValue($transactions))}}</p>
                            </div>



                        </div>
                    </span>
                </div>
            </div>
        </div>

    </div>

@endsection

