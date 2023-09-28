<?php

namespace Tests\Feature;

use App\Services\LoanCalculatorService;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class LoanCalculatorTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test the /calculate endpoint.
     */
    public function test_calculate_api_endpoint()
    {
        $data = [
            'loan_amount' => 1000,
            'annual_interest_rate' => 10,
            'loan_term' => 1,
        ];

        $response = $this->postJson('/api/calculate', $data);

        $response->assertStatus(200);
        $response->assertJsonStructure([
            'schedules' => [
                'regular' => [],
                'extra' => []
            ],
            'request' => []
        ]);
    }

    /**
     * Test the loan amount validation.
     */
    public function test_loan_amount_is_required()
    {
        $data = [
            'annual_interest_rate' => 5,
            'loan_term' => 20,
        ];

        $response = $this->postJson('/api/calculate', $data);

        $response->assertStatus(422); // HTTP 422 is for validation errors
        $response->assertJsonValidationErrors(['loan_amount']);
    }

    /**
     * Test the Service Logic
     */
    public function test_loan_calculator_service()
    {
        $service = new LoanCalculatorService();
        $request = [
            'loan_amount' => 1000,
            'annual_interest_rate' => 10,
            'loan_term' => 1,
        ];
        $schedule = $service->schedule($request);

        $this->assertIsArray($schedule);
        $this->assertArrayHasKey('regular', $schedule);
        $this->assertArrayHasKey('extra', $schedule);
        $this->assertEquals(json_decode('{
        "regular": [
            {
                "loan_id": 1,
                "month_number": 1,
                "starting_balance": 1000.0,
                "monthly_payment": 87.92,
                "principal_component": 79.58,
                "interest_component": 8.33,
                "ending_balance": 920.42
            },
            {
                "loan_id": 1,
                "month_number": 2,
                "starting_balance": 920.42,
                "monthly_payment": 87.92,
                "principal_component": 80.25,
                "interest_component": 7.67,
                "ending_balance": 840.17
            },
            {
                "loan_id": 1,
                "month_number": 3,
                "starting_balance": 840.17,
                "monthly_payment": 87.92,
                "principal_component": 80.91,
                "interest_component": 7.0,
                "ending_balance": 759.26
            },
            {
                "loan_id": 1,
                "month_number": 4,
                "starting_balance": 759.26,
                "monthly_payment": 87.92,
                "principal_component": 81.59,
                "interest_component": 6.33,
                "ending_balance": 677.67
            },
            {
                "loan_id": 1,
                "month_number": 5,
                "starting_balance": 677.67,
                "monthly_payment": 87.92,
                "principal_component": 82.27,
                "interest_component": 5.65,
                "ending_balance": 595.4
            },
            {
                "loan_id": 1,
                "month_number": 6,
                "starting_balance": 595.4,
                "monthly_payment": 87.92,
                "principal_component": 82.95,
                "interest_component": 4.96,
                "ending_balance": 512.45
            },
            {
                "loan_id": 1,
                "month_number": 7,
                "starting_balance": 512.45,
                "monthly_payment": 87.92,
                "principal_component": 83.65,
                "interest_component": 4.27,
                "ending_balance": 428.8
            },
            {
                "loan_id": 1,
                "month_number": 8,
                "starting_balance": 428.8,
                "monthly_payment": 87.92,
                "principal_component": 84.34,
                "interest_component": 3.57,
                "ending_balance": 344.46
            },
            {
                "loan_id": 1,
                "month_number": 9,
                "starting_balance": 344.46,
                "monthly_payment": 87.92,
                "principal_component": 85.05,
                "interest_component": 2.87,
                "ending_balance": 259.41
            },
            {
                "loan_id": 1,
                "month_number": 10,
                "starting_balance": 259.41,
                "monthly_payment": 87.92,
                "principal_component": 85.75,
                "interest_component": 2.16,
                "ending_balance": 173.66
            },
            {
                "loan_id": 1,
                "month_number": 11,
                "starting_balance": 173.66,
                "monthly_payment": 87.92,
                "principal_component": 86.47,
                "interest_component": 1.45,
                "ending_balance": 87.19
            },
            {
                "loan_id": 1,
                "month_number": 12,
                "starting_balance": 87.19,
                "monthly_payment": 87.92,
                "principal_component": 87.19,
                "interest_component": 0.73,
                "ending_balance": 0
            }
        ],
        "extra": []
    }', true), $schedule);
    }

    /**
     * Test Database Integration
     */
    public function test_loan_amortization_schedule_is_saved()
    {
        $service = new LoanCalculatorService();
        $request = [
            'loan_amount' => 100000,
            'annual_interest_rate' => 5,
            'loan_term' => 20,
        ];
        $service->schedule($request);

        $this->assertDatabaseCount('loan_amortization_schedules', 20 * 12);
    }
}
