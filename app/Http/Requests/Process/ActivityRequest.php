<?php

namespace App\Http\Requests\Process;

use App\Abstracts\Http\FormRequest;

class ActivityRequest extends FormRequest
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
            'result' => 'required',
            'product' => 'required',
            'specs' => 'required',
            'cares' => 'required',
            'procedures' => 'required',
            'equipment' => 'required',
            'supplies' => 'required'
        ];
    }
}
