@extends('layouts.default')

@section('content')
<div class="mt-8 bg-white dark:bg-gray-800 overflow-hidden shadow sm:rounded-lg">
    <div class="grid grid-cols-1 md:grid-cols-2">
        <div class="p-6">
            <div class="flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-8 h-8 text-gray-500"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 006 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 016 18c2.305 0 4.408.867 6 2.292m0-14.25a8.966 8.966 0 016-2.292c1.052 0 2.062.18 3 .512v14.25A8.987 8.987 0 0018 18a8.967 8.967 0 00-6 2.292m0-14.25v14.25" /></svg>
                <div class="ml-4 text-lg leading-7 font-semibold">Mortgage Loan Calculator</div>
            </div>

            <div class="ml-12">
                <div class="mt-2 text-gray-600 dark:text-gray-400 text-sm">
                    <form action="{{ route('calculate') }}" method="post" class="container mt-5">
                        @csrf

                        <div class="form-group">
                            <label for="loan_amount">Loan Amount:</label>
                            <input type="number" class="form-control" name="loan_amount" id="loan_amount" step="1" >
                        </div>

                        <div class="form-group">
                            <label for="interest_rate">Annual Interest Rate (%):</label>
                            <input type="number" class="form-control" name="annual_interest_rate" id="interest_rate" step="1" >
                        </div>

                        <div class="form-group">
                            <label for="loan_term">Loan Term (years):</label>
                            <input type="number" class="form-control" name="loan_term" id="loan_term" step="1" >
                        </div>

                        <div class="form-group">
                            <label for="extra_repayment">Monthly Fixed Extra Payment (optional):</label>
                            <input type="number" class="form-control" name="extra_payment" id="extra_repayment" step="1" >
                        </div>

                        <button type="submit" class="btn btn-primary">Calculate</button>
                    </form>
                </div>
            </div>
        </div>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>
</div>
@stop
