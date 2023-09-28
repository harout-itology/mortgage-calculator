<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Loan extends Model
{
    use HasFactory;

    public function loanAmortizationSchedules(): HasMany
    {
        return $this->hasMany(LoanAmortizationSchedule::class);
    }

    public function extraRepaymentSchedule(): HasMany
    {
        return $this->hasMany(ExtraRepaymentSchedule::class);
    }
}
