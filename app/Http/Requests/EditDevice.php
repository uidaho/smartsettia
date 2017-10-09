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
            'name' => 'required|string|max:255',
            'site' => 'required_without:new_site_name|int|max:255|nullable',
            'new_site_name' => 'required_without:site|unique:sites,name|nullable',
            'location' => 'required_without:new_location_name|int|max:255|nullable',
            'new_location_name' => 'required_without:location|unique:locations,name|string|max:255|nullable',
            'open_time' => 'required|date_format:H:i',
            'close_time' => 'required|date_format:H:i',
            'update_rate' => 'required|int|max:255',
            'image_rate' => 'required|int|max:255',
            'sensor_rate' => 'required|int|max:255',
        ];
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
            'open_time.date_format:H:i'  => 'A open time most be in the format hour:minutes',
            'close_time.required'  => 'A close time for the device is required',
            'close_time.date_format:H:i'  => 'A close time most be in the format hour:minutes',
            'update_rate.required'  => 'A update rate for the device is required',
            'image_rate.required'  => 'A image rate for the device is required',
            'sensor_rate.required'  => 'A sensor rate for the device is required',
        ];
    }
}
