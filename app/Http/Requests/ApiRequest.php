<?php

namespace App\Http\Requests;

use App\Constants\ReturnStatusConstant;
use App\Exceptions\ApiException;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;

class ApiRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

    /*
     * 重载验证失败后的异常处理
     */
    public function failedValidation(Validator $validator)
    {
        throw new ApiException(implode(';', $validator->errors()->all()), ReturnStatusConstant::STATUS_PARAMS, ReturnStatusConstant::STATUS_PARAMS);
    }
}
