<?php

namespace App\Actions\Fortify;

use Laravel\Fortify\Rules\Password;

trait PasswordValidationRules
{
    /**
     * Get the validation rules used to validate passwords.
     *
     * @return array
     */
    protected function passwordRules()
    {

        // Require at least 10 characters...
        // Require at least one uppercase character...
        // Require at least one numeric character...
        // Require at least one special character...
        return [
            'required', 'string',
            (new Password)->length(8)
                ->requireSpecialCharacter()
                ->requireNumeric()
                ->requireUppercase(),
            'confirmed'
        ];
    }
}
