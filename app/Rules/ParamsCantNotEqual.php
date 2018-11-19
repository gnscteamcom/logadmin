<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class ParamsCantNotEqual implements Rule
{
    private $other_attribute;
    private $other_attribute_val;

    /**
     * ParamsCantNotEqual constructor.
     * @param $other_attribute
     * @param $other_attribute_val
     */
    public function __construct($other_attribute, $other_attribute_val)
    {
        $this->other_attribute = $other_attribute;
        $this->other_attribute_val = $other_attribute_val;
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
        if($value === $this->other_attribute_val) {
            return false;
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.attribute_cant_equal_attribute');
    }
}
