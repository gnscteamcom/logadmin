<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\ApiRequest;
use App\Rules\IsParamI18n;
use App\Rules\UniqueJsonParam;

class RoleStoreRequest extends ApiRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name'      => [
                'required',
                new IsParamI18n(),
                new UniqueJsonParam('resource_groups', 'name'),
            ],
            'level'     => 'nullable|integer|min:0|max:255',
            'parent_id' => 'nullable|numeric|exists:roles,id',
        ];
    }


}
