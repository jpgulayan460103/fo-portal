<?php

namespace App\Rules;

use App\Models\OneTimePassword;
use Illuminate\Contracts\Validation\Rule;

class ValidOtp implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $otpCode = request('otpCode');
        $referenceNumber = request('referenceNumber');

        $otp = OneTimePassword::where('reference_number', $referenceNumber)->where('otp_code', $otpCode)->count();
        return $otp === 1;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Invalid one-time password.';
    }
}
