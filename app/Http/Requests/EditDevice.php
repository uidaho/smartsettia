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
            'command' => 'sometimes|required|string|max:6|in:open,close,lock,unlock',
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
    
        $validator->sometimes('site_id', 'bail|required|integer|digits_between:1,10|exists:sites,id', function ($input) {
            return !$input->new_site_name && $input->site_id;
        });
    
        $validator->sometimes('location_id', 'bail|required|integer|digits_between:1,10|exists:locations,id', function ($input) {
            return !$input->new_location_name && $input->location_id;
        });
    
        $validator->sometimes('new_site_name', 'bail|required|string|max:75|unique:sites,name', function ($input) {
            return !$input->site_id;
        });
    
        $validator->sometimes('new_location_name', 'bail|required|string|max:75|unique:locations,name', function ($input) {
            return !$input->location_id;
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
            'site_id.required' => 'A site is required',
            'new_site_name.required' => 'A site is required',
            'location_id.required' => 'A location is required',
            'new_location_name.required' => 'A location is required',
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
