<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditLocation extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->isUser();
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => 'required|min:2|max:75|name',
        ];
    }
    
    /**
     * Get the validation rules that apply to the request.
     *
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function getValidatorInstance()
    {
        $validator = parent::getValidatorInstance();
        
        $validator->sometimes('site', 'integer|digits_between:1,10|exists:sites,id', function ($input) {
            return !$input->new_site_name && $input->site;
        });
        
        $validator->sometimes('new_site_name', 'bail|min:2|max:190|name|unique:sites,name', function ($input) {
            return !$input->site;
        });
        
        return $validator;
    }
    
    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'A location name is required',
            'new_site_name.unique'  => 'The site name must be unique',
            'new_site_name.min'  => 'The new site must be at least 2 characters',
        ];
    }
}