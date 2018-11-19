<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\ApiRequest;
use App\Rules\EachArrayExistsOrEmpty;

class ResourceTreeRequest extends ApiRequest
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
            'user_id'  => 'nullable|numeric|exists:users,id',
            'group_id' => 'nullable|numeric|exists:resource_groups,id',
            'role_id'  => 'nullable|numeric|exists:roles,id',
            'role_ids' => [
                'nullable',
                'array',
                new EachArrayExistsOrEmpty('roles', 'id')
            ]
        ];
    }
}
