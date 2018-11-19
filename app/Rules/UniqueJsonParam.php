<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class UniqueJsonParam implements Rule
{
    private $table;
    private $field;

    /**
     * UniqueJsonParam constructor.
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
        $wheres[] = [$this->field ? $this->field : $attribute, '=', is_string($value) ? $value : json_encode($value)];
        return DB::table($this->table)->where($wheres)->get()->isEmpty();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.unique');
    }
}
