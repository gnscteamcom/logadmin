<?php

namespace App\Rules;

use App\Helpers\BaseHelper;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

/**
 * Class UniqueUnionKey
 * @package App\Rules
 *
 * validator验证规则
 */
class UniqueUnionKey implements Rule
{
    private $table;
    private $field;
    private $union_field;
    private $union_field_val;

    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct(/*表名*/
        $table, /*列名*/
        $field, /*与之关联的列名*/
        $union_field, /*与之关联的列的数据*/
        $union_field_val)
    {
        $this->table           = $table;
        $this->field           = $field;
        $this->union_field     = $union_field;
        $this->union_field_val = $union_field_val;
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
        $wheres[] = [$this->field ? $this->field : $attribute, '=', $value];
        $wheres[] = [$this->union_field, '=', $this->union_field_val];

        return DB::table($this->table)->where($wheres)->get()->isEmpty();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.custom.data_repeated');
    }
}
