<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\ApiRequest;
use App\Rules\IsParamI18n;
use App\Rules\NotZeroExists;
use App\Rules\UniqueJsonParam;

class ResourceGroupUpdateRequest extends ApiRequest
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
            'id'        => [
                'required',
                'numeric',
                'exists:resource_groups,id',
            ],
            'name'      => [
                'nullable',
                new IsParamI18n(),
                new UniqueJsonParam('resource_groups', 'name'),
            ],
//            'parent_id' => 'nullable|exists:resource_groups,id',
            'parent_id' => [
                'nullable',
                'numeric',
                new NotZeroExists('resource_groups', 'id')
            ],
        ];
    }
}
