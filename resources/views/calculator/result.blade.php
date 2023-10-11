@extends('layouts.default')

@section('content')
    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-1">
            <div class="p-6">
                <div class="flex items-center">
                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                    <div class="ml-4 text-lg leading-7 font-semibold">Mortgage Loan Calculator</div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                        <table class="table table-bordered">
                            <thead>
                            <tr>
                                <th>Loan Amount</th>
                                <th>Annual Interest Rate (%)</th>
                                <th>Loan Term (years)</th>
                                <th>Monthly Fixed Extra Payment</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td>{{ $request['loan_amount'] }}</td>
                                <td>{{ $request['annual_interest_rate'] }}</td>
                                <td>{{ $request['loan_term'] }}</td>
                                <td>{{ $request['extra_payment'] }}</td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @foreach($schedules as $key => $schedule)
        @if ($schedule)
        <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
            <div class="grid grid-cols-1">
                <div class="p-6">
                    <div class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                        <div class="ml-4 text-lg leading-7 font-semibold">Amortization Schedule @if($key === 'extra') (With Extra Payment) @endif</div>
                    </div>

                    <div class="ml-12">
                        <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                            <table class="table table-bordered">
                                <thead>
                                <tr>
                                    <th>Month</th>
                                    <th>Starting Balance</th>
                                    <th>Monthly Payment</th>
                                    <th>Principal Component</th>
                                    <th>Interest Component</th>
                                    @if($key === 'extra')<th>Fixed Extra Payment</th>@endif
                                    <th>Ending Balance</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($schedule as $record)
                                    <tr>
                                        <td>{{ $record['month_number'] }}</td>
                                        <td>{{ $record['starting_balance'] }}</td>
                                        <td>{{ $record['monthly_payment'] }}</td>
                                        <td>{{ $record['principal_component'] }}</td>
                                        <td>{{ $record['interest_component'] }}</td>
                                        @if($key === 'extra')<td>{{ $record['extra_payment'] }}@endif</td>
                                        <td>{{ $record['ending_balance'] }}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @endforeach
    <div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
        <div class="grid grid-cols-1">
            <div class="p-6">
                <a href="javascript:history.back()"> <-- Back</a>
            </div>
        </div>
    </div>
@stop
