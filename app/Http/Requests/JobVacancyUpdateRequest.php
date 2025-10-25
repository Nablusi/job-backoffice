<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
 

class JobVacancyUpdateRequest extends FormRequest
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
            "title"=> "required|string|max:255|unique:companies,name," . $this->route('job_vacancy'),
            "location"=> "required|string|max:500",
            "description"=> "required|string|max:5000",
            "salary"=> "required|string|max:5000",
            "categoryId"=> "required|exists:job_categories,id",
            "companyId"=> "required|exists:companies,id",

        ];


    }

    public function messages(): array
    {
        return [
            "title.required" => "The job title is required.",
            "title.string" => "The job title must be a string.",
            "title.max" => "The job title must not exceed 255 characters.",
            "location.required" => "The location is required.",
            "location.string" => "The location must be a string.",
            "location.max" => "The location must not exceed 500 characters.",
            "description.required" => "The description is required.",
            "description.string" => "The description must be a string.",
            "description.max" => "The description must not exceed 5000 characters.",
            "salary.required" => "The salary is required.",
            "salary.string" => "The salary must be a string.",
            "salary.max" => "The salary must not exceed 5000 characters.",
            "categoryId.required" => "The job category is required.",
            "categoryId.exists" => "The job category does not exist.",
            "companyId.required" => "The company is required.",
            "companyId.exists" => "The company does not exist.",


        ];

    }
}
