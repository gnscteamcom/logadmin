<?php

namespace App\Http\Requests\Permission;

use App\Http\Requests\ApiRequest;
use App\Rules\EachArrayExistsOrEmpty;
use App\Rules\ZeroOrExists;

class ResourceBindGroupRequest extends ApiRequest
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
            'group_id'     => [
                'required',
                'numeric',
                new ZeroOrExists('resource_groups', 'id')
            ],
            'rebind'       => 'nullable|in:0,1',
            'resource_ids' => [
                'nullable',
                'array',
                new EachArrayExistsOrEmpty('resources', 'id')
            ]
        ];
    }
}
