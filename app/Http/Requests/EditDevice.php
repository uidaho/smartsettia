<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class EditDevice extends FormRequest
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
            'name' => 'required|string|max:75',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i',
            'update_rate' => 'required|integer|digits_between:1,7',
            'image_rate' => 'required|integer|digits_between:1,7',
            'sensor_rate' => 'required|integer|digits_between:1,7',
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
    
        $validator->sometimes('site', 'bail|integer|digits_between:1,10|exists:sites,id', function ($input) {
            return !$input->new_site_name;
        });
    
        $validator->sometimes('location', 'bail|integer|digits_between:1,10|exists:locations,id', function ($input) {
            return !$input->new_location_name;
        });
    
        $validator->sometimes('new_site_name', 'bail|string|max:75|unique:sites,name', function ($input) {
            return !$input->site;
        });
    
        $validator->sometimes('new_location_name', 'bail|string|max:75|unique:locations,name', function ($input) {
            return !$input->location;
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
            'name.required' => 'A device name is required',
            'open_time.required'  => 'A open time for the device is required',
            'open_time.date_format:H:i'  => 'A open time must be in the format hour:minutes',
            'close_time.required'  => 'A close time for the device is required',
            'close_time.date_format:H:i'  => 'A close time must be in the format hour:minutes',
            'update_rate.required'  => 'A update rate for the device is required',
            'image_rate.required'  => 'A image rate for the device is required',
            'sensor_rate.required'  => 'A sensor rate for the device is required',
        ];
    }
}
