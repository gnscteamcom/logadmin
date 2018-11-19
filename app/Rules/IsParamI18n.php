<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class IsParamI18n implements Rule
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
        if(!is_array($value)) {
            return false;
        }

        if(!(key_exists('zh-CN',$value) && isset($value['zh-CN']))) {
            return false;
        }

        if(!(key_exists('en-US',$value) && isset($value['en-US']))) {
            return false;
        }

        if(!(key_exists('id-ID',$value) && isset($value['id-ID']))) {
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
        return trans('validation.custom.param_i18n_cant_null');
    }
}
