@extends('layouts.main')


@section('content')

    <div>

        <div class="grid sm:grid-cols-3 gap-6">

            <div
                class="col-span-1 bg-sellar-100 rounded-lg hover:bg-sellar-200 md:hover:cursor-pointer transition duration-300">
                <a href="{{route("users.kpi.index")}}"
                >
                    <div class="py-8 px-6">
                        <div class="flex items-center justify-center justify-items-center">
                            <x-icons.users classs="h-5 w-5"></x-icons.users>
                            <span class="text-gray-300 text-xl text-center">Users KPI</span>
                        </div>

                    </div>
                </a>
            </div>

            <div
                class="col-span-1 bg-sellar-100 rounded-lg hover:bg-sellar-200 md:hover:cursor-pointer transition duration-300">
                <a href="{{route('products.kpi.index')}}"
                >
                    <div class="py-8 px-6">
                        <div class="flex items-center justify-center justify-items-center">
                            <x-icons.chart-pie classs="h-5 w-5"></x-icons.chart-pie>
                            <span class="text-gray-300 text-xl text-center">Products KPI</span>
                        </div>

                    </div>
                </a>
            </div>

            <div
                class="col-span-1 bg-sellar-100 rounded-lg hover:bg-sellar-200 md:hover:cursor-pointer transition duration-300">
                <a href="{{route("transactions.kpi.index")}}"
                >
                    <div class="py-8 px-6">
                        <div class="flex items-center justify-center justify-items-center">
                            <x-icons.money classs="h-5 w-5"></x-icons.money>
                            <span class="text-gray-300 text-xl text-center">Transactions KPI</span>
                        </div>

                    </div>
                </a>
            </div>


        </div>
    </div>

@endsection
