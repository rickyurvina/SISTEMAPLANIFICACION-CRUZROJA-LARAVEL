<?php

namespace App\Http\Requests\Process;


use App\Abstracts\Http\FormRequest;

class NonConformityRequest extends FormRequest
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
            'number' => 'required',
            'code' => 'required',
            'process' => 'required',
            'division' => 'required',
            'date' => 'required',
            'corrective_action' => 'required',
            'raw_materials' => 'required',
            'product' => 'required',
            'complaints' => 'required',
            'description' => 'required',
            'evidence' => 'required'

        ];
    }
}
