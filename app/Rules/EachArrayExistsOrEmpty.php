<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EachArrayExistsOrEmpty implements Rule
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
        if (is_array($value)) {
            foreach ($value as $item) {
                if (DB::table($this->table)->where(($this->field ? $this->field : $attribute), $item)->get()->isEmpty()) {
                    return false;
                }
            }
        } else {
            if($value) {
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
        return trans('validation.exists');
    }
}
