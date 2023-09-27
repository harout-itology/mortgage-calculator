<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculatorRequest;
use App\Services\LoanCalculatorService;
use Illuminate\Contracts\View\View;

class LoanCalculatorController extends Controller
{
    public function __construct(public LoanCalculatorService $myService)
    {
    }

    public function index(): View
    {
        return view('calculator.index');
    }

    public function calculate(CalculatorRequest $request): View
    {
        $amortizationSchedule = $this->myService->schedule($request->all());

        return view('calculator.result', compact('amortizationSchedule'));
    }
}
