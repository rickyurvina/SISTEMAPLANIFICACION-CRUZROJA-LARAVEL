<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateGeneratedServiceRequest extends FormRequest
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
            'code' => [
                'required',
                'max:5',
                'alpha_num',
                'alpha_dash',
                Rule::unique('generated_services')
                    ->ignore($this->code)
                    ->where('deleted_at', null)
            ],
            'name' => 'required|max:200',
            'description' => 'required|max:500',
        ];
    }
}
