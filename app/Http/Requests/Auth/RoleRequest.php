<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;
use Str;

class RoleRequest extends FormRequest
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
        // Check if store or update
        if (strtolower($this->getMethod()) == 'put') {
            $id = is_numeric($this->role) ? $this->role : $this->role->getAttribute('id');
        } else {
            $id = -1;
        }

        return [
            'name' => 'required|string|unique:roles,name,' . $id,
            'permissions' => 'required'
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'permissions.required' => 'Los permisos son requeridos. Seleccione al menos uno.',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param Validator $validator
     *
     * @return void
     */
    public function withValidator(Validator $validator)
    {
        $validator->after(function ($validator) {
            if($validator->failed()){
                $validator->errors()->add('validated', ' ');
            }
        });
    }
}
