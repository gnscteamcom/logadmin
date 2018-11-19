<?php

namespace App\Http\Requests\Admin;

use App\Rules\ResourceAllowMethod;
use App\Rules\UniqueUnionKey;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends FormRequest
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
            'uri'    => 'required|min:1',
            'method' => [
                'required',
//                    Rule::in(ResourceConstant::METHOD),
                new ResourceAllowMethod(),
                new UniqueUnionKey('resources', 'method', 'uri', $this->get('uri'))
            ],
            'name'   => 'nullable|max:64'
        ];
    }
}
