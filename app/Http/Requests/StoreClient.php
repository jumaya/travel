<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreClient extends FormRequest
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
            'first_name' => 'required|string|max:128',
            'last_name' => 'required|max:128',
            'email' => 'required|string|email|max:255|unique:client',   
            'address' => 'required|max:255',
            'phone' => 'required|max:30',
            'photo' => 'image|mimes:jpeg,png,jpg,gif,svg|max:8000',           
        ];
    }
}
