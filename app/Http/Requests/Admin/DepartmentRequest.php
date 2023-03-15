<?php

namespace App\Http\Requests\Admin;

use App\Abstracts\Http\FormRequest;

class DepartmentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'code' => 'required|min:3|max:3',
            'name' => 'required',
            'responsible' => 'required|exists:users,id',
        ];
    }
}
