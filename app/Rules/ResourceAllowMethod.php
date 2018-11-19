<?php

namespace App\Rules;

use App\Constants\ResourceConstant;
use Illuminate\Contracts\Validation\Rule;

class ResourceAllowMethod implements Rule
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

        $arr = explode('|', $value);

        if(empty($arr)) return false;

        foreach ($arr as $item) {
            if(!in_array(mb_strtoupper($item), ResourceConstant::METHOD)) {
                return false;
            }
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
        return trans('validation.custom.method_not_allow');
    }
}
