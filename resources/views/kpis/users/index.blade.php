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
            @if(request()->hasAny(['user_category', 'date.to', 'date.from']))
                <a href="{{route('users.kpi.index')}}" class="max-w-lg flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm
                text-sm font-medium text-white bg-gray-600 hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500">
                    Reset Filter
                </a>
            @endif
        </div>


        <div class="bg-white shadow-md  w-full sm:rounded-lg sm:overflow-hidden">
            <div class="px-1 pb-8 pt-6">
                <div class="mt-4  p-1 pt-0">
                    <form class="space-y-6" method="GET" action="{{route('users.kpi.all-users')}}">
                        @csrf
                        <div class="grid grid-cols-2 space-x-2">
                            <div class="ml-2">
                                <x-form.label>Select User Category</x-form.label>
                                <div class="grid grid-cols-4 mt-1">
                                    @foreach($userCategories as $userCategoryValue => $userCategoryTitle)
                                        <div>
                                            <input type="checkbox"
                                                   name="user_category[]"
                                                   {{ in_array($userCategoryValue, request()->input("user_category") ?? old('user_category') ?? []) ? 'checked' : '' }}
                                                   value="{{$userCategoryValue}}"
                                                   class="flex  shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm border-gray-300 rounded-lg">
                                            <label>{{$userCategoryTitle}}</label>
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

            @foreach($userCategoryCount as $userCategoryKey => $_userCategoryCount)
                <span
                    class="col-span-1 bg-sellar-100 rounded-lg hover:bg-sellar-200 md:hover:cursor-pointer transition duration-300">
            <div class="py-8 px-6">
              <div class="flex items-center justify-center justify-items-center">
                <x-icons.users classs="h-5 w-5"></x-icons.users>
                    <span class="text-gray-300 text-xl text-center">{{userCategoryTitle($userCategoryKey)}}</span>
                </div>
                <div class="mt-3 mb-1 text-white font-semibold text-xl">
                   <p>Total : {{$_userCategoryCount}}</p>
                </div>

        </div>
        </span>
            @endforeach


        </div>
    </div>

@endsection
