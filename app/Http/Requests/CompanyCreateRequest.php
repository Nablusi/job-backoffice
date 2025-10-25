<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompanyCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            "name"=> "required|string|max:255|unique:companies,name",
            "address"=> "required|string|max:500",
            "industry"=> "required|string|max:255",
            "website"=> "nullable|url|max:255",

            //owner details 
            'owner_name' => 'required|string|max:500',
            'owner_email'=> 'required|email|max:500|unique:users,email',
            'owner_password'=> 'required|string|min:8',
        ];
    }

    public function messages(): array
    {
        return [
            "name.required" => "The company name is required.",
            "name.string" => "The company name must be a string.",
            "name.max" => "The company name must not exceed 255 characters.",
            "name.unique" => "The company name has already been taken.",
            "address.required" => "The address is required.",
            "address.string" => "The address must be a string.",
            "address.max" => "The address must not exceed 500 characters.",
            "industry.required" => "The industry is required.",
            "industry.string" => "The industry must be a string.",
            "industry.max" => "The industry must not exceed 255 characters.",
            "website.url" => "The website must be a valid URL.",
            "website.max" => "The website must not exceed 255 characters.",
            // owner details
            "owner_name.required"=> "The owner name is required.",
            "owner_name.max"=> "The owner name must not exceed 255 characters.",
            "owner_name.string"=> "The owner name must be a string.",


            "owner_email.email"=> "The owner name must be a unique.",
            "owner_email.required"=> "The owner email is required.",

            "owner_password.required"=> "The owner password is required.",
            "owner_password.min"=> "The password must be at least 8 char",



        ];
    }
}
