<?php


namespace App\Http\Validator;


interface ApiValidator
{
    public function rules();

    public function messages();
}