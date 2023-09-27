<?php

namespace App\Services;

use App\Models\Loan;
use App\Models\LoanAmortizationSchedule;

class LoanCalculatorService
{
    public function schedule(array $request): array
    {
        $loanAmount = $request['loan_amount'];
        $annualInterestRate = $request['annual_interest_rate'];
        $loanTerm = $request['loan_term'];
        $extraPayment = $request['extra_payment'] ?? 0;

        // Store the loan in the database
        $loan = Loan::create();

        // Convert annual interest rate to monthly
        $monthlyInterestRate = $annualInterestRate / 12 / 100;

        // Calculate total number of months
        $numMonths = $loanTerm * 12;

        // Calculate monthly payment
        $monthlyPayment = ($loanAmount * $monthlyInterestRate) / (1 - pow((1 + $monthlyInterestRate), -$numMonths));

        // Calculate the current balance
        $remainingBalance = $loanAmount;

        // Initialize variables for amortization schedule
        $amortizationSchedule = [];

        for ($month = 1; $month <= $numMonths; $month++)
        {
            // Calculate interest component for this month
            $interestPayment = $remainingBalance * $monthlyInterestRate;

            // Calculate principal component for this month
            $principalPayment = $monthlyPayment - $interestPayment;

            // Calculate the balance for the next month
            $endingBalance = $remainingBalance - $principalPayment;

            // Ensure ending balance doesn't go negative in the regular schedule
            if ($endingBalance < 0) {
                $principalPayment += $endingBalance;
                $endingBalance = 0;
            }

            // Add data to the amortization schedule
            $amortizationSchedule[] = [
                'loan_id' => $loan->id,
                'month_number' => $month,
                'starting_balance' => $remainingBalance,
                'monthly_payment' => $monthlyPayment,
                'principal_component' => $principalPayment,
                'interest_component' => $interestPayment,
                'ending_balance' => $endingBalance
            ];

            // Update remaining balance
            $remainingBalance = $endingBalance;
        }

        // Store the amortization schedule in the database
        LoanAmortizationSchedule::insert($amortizationSchedule);

        return $amortizationSchedule;
    }
}
