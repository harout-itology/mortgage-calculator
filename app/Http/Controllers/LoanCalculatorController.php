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
        return view('calculator.result', [
            'schedules' => $this->myService->schedule($request->all()),
            'request' => $request->all(),
        ]);
    }
}
