<?php

namespace App\Rules;

use App\Inspections\Spam;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\Log;

class SpamFree implements Rule
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
        try {
           Log::alert("passes reached");
            return ! resolve(Spam::class)->detect($value);
        } catch (\Exception $e) {
           // dd("caught");
            return false;
        }

    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'The :attribute must be uppercase.';
    }
}
