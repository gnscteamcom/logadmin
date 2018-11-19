<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\ApiRequest;
use App\Rules\EachArrayExists;
use App\Rules\EachArrayExistsOrEmpty;

class ResourceBindRoleRequest extends ApiRequest
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
            'role_id'     => 'required|numeric|exists:roles,id',
            'rebind'       => 'nullable|in:0,1',
            'resource_ids' => [
                'nullable',
                'array',
                new EachArrayExistsOrEmpty('resources', 'id')
            ]
        ];
    }
}
