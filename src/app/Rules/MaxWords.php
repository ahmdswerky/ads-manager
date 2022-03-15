<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class MaxWords implements Rule
{
    protected $attribute;

    protected $maxLength;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct($maxLength)
    {
        $this->maxLength = $maxLength;
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
        $this->attribute = $attribute;
        $words = explode(" ", $value);

        return count($words) <= $this->maxLength;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return __('validation.max_words', [
            'attribute' => $this->attribute,
            'max' => $this->maxLength,
        ]);
    }
}
