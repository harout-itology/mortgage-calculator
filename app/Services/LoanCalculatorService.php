<?php

namespace App\Services;

use App\Helpers\CalculateHelper;
use App\Models\ExtraRepaymentSchedule;
use App\Models\Loan;
use App\Models\LoanAmortizationSchedule;

class LoanCalculatorService
{
    const MONTHS_IN_YEAR = 12;

    public function schedule(array $request): array
    {
        $loan = Loan::create();

        $loanAmount = $request['loan_amount'];
        $extraPayment = $request['extra_payment'] ?? 0;
        $monthlyInterestRate = $request['annual_interest_rate'] / self::MONTHS_IN_YEAR / 100;
        $numMonths = $request['loan_term'] * self::MONTHS_IN_YEAR;
        $monthlyPayment = $this->calculateMonthlyPayment($loanAmount, $monthlyInterestRate, $numMonths);

        $amortizationSchedule = $this->amortizationSchedule($loan->id, $numMonths, $loanAmount, $monthlyInterestRate, $monthlyPayment);
        LoanAmortizationSchedule::insert($amortizationSchedule);

        $extraRepaymentSchedule = [];
        if ($extraPayment > 0) {
            $extraRepaymentSchedule = $this->amortizationSchedule($loan->id, $numMonths, $loanAmount, $monthlyInterestRate, $monthlyPayment, $extraPayment);
            ExtraRepaymentSchedule::insert($extraRepaymentSchedule);
        }

        return ['regular' => $amortizationSchedule, 'extra' => $extraRepaymentSchedule];
    }

    protected function calculateMonthlyPayment($loanAmount, $monthlyInterestRate, $numMonths): float
    {
        return ($loanAmount * $monthlyInterestRate) / (1 - pow((1 + $monthlyInterestRate), -$numMonths));
    }

    protected function amortizationSchedule($loanId, $numMonths, $initialBalance, $monthlyInterestRate, $monthlyPayment, $extraPayment = 0): array
    {
        $schedule = [];
        $remainingBalance = $initialBalance;  // for interest calculations
        $effectiveBalance = $initialBalance;  // for payment calculations

        for ($month = 1; $month <= $numMonths && $effectiveBalance > 0; $month++)
        {
            $interestPayment = $remainingBalance * $monthlyInterestRate;
            $principalPayment = min($monthlyPayment - $interestPayment, $effectiveBalance);
            $actualExtraPayment = min($extraPayment, $effectiveBalance - $principalPayment);

            $endingBalance = $effectiveBalance - $principalPayment - $actualExtraPayment;

            $records = [
                'loan_id' => $loanId,
                'month_number' => $month,
                'starting_balance' => CalculateHelper::format($effectiveBalance),
                'monthly_payment' => CalculateHelper::format($monthlyPayment),
                'principal_component' => CalculateHelper::format($principalPayment),
                'interest_component' => CalculateHelper::format($interestPayment),
                'ending_balance' => CalculateHelper::format($endingBalance)
            ];
            if ($extraPayment) { // show extra payment only if needed
                $records['extra_payment'] = CalculateHelper::format($actualExtraPayment);
            }
            $schedule[] = $records;

            $effectiveBalance = $endingBalance;
            $remainingBalance -= $principalPayment;  // only principal, as the interest for the next month is based on this.
        }

        return $schedule;
    }
}
