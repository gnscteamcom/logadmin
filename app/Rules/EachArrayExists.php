<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EachArrayExists implements Rule
{
    private $table;
    private $field;

    /**
     * NotZeroExists constructor.
     * @param $table
     * @param $field
     */
    public function __construct($table, $field)
    {
        $this->table = $table;
        $this->field = $field;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string $attribute
     * @param  mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (is_array($value) && count($value) > 0) {
            foreach ($value as $item) {
                if($item === 0 || $item === '0') {
                    continue;
                }
                if (DB::table($this->table)->where(($this->field ? $this->field : $attribute), $item)->get()->isEmpty()) {
                    return false;
                }
            }
            return true;
        }
        return false;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.exists');
    }
}
