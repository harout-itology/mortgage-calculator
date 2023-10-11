<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculatorRequest;
use App\Services\LoanCalculatorService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class LoanCalculatorController extends Controller
{
    public function __construct(public LoanCalculatorService $myService)
    {
    }

    public function index(): View
    {
        return view('calculator.index');
    }

    public function calculate(CalculatorRequest $request): View|JsonResponse
    {
        $result = [
            'schedules' => $this->myService->schedule($request->all()),
            'request' => $request->all(),
        ];

        if ($request->wantsJson()) {
            return response()->json($result);
        }
        return view('calculator.result', $result);
    }
}
