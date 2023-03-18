<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CountryRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            //
            'slug' => 'required|string|unique:countries,slug',
            'country' => 'required|string|unique:countries,country',
            'country_code' => 'required|string||unique:countries,country_code',
            'new_confirmed' => 'required|integer',
            'total_confirmed' => 'required|integer',
            'new_deaths' => 'required|integer',
            'new_recovered' => 'required|integer',
            'total_recovered' => 'required|integer',
            'total_deaths' => 'required|integer',

        ];
    }
    public function messages()
    {
        return [
            'slug.required' => 'Slug is required.',
            'slug.unique' => 'Slug already exists.',
            'country.required' => 'Country is required.',
            'country.unique' => 'Country already exists.',
            'new_confirmed.required' => 'New confirmed email format.',
            'total_confirmed.required' => 'Total confirmed is required',
            'new_deaths.required' => 'New deaths is required',
            'new_recovered.required' => 'New recovered is required',
            'total_recovered.required' => 'Total recovered is required',
        ];
    }
}
