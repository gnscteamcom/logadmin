<?php

namespace App\Http\Validator\Admin;


use App\Constants\ResourceConstant;
use App\Http\Validator\ApiValidator;
use App\Rules\UniqueUnionKey;
use Illuminate\Validation\Rule;

class AddResourceValidator implements ApiValidator
{
    public function rules()
    {
        return [
            'uri'    => 'required|min:1',
            'method' => [
                'required',
                Rule::in(ResourceConstant::METHOD),
                new UniqueUnionKey('resources','method','uri',$params['uri'])
            ],
            'name' => 'nullable|max:64'
        ];
    }
    public function messages()
    {
        return [

        ];
    }
}
