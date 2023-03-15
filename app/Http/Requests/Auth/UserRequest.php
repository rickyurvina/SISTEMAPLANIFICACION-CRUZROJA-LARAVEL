<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class UserRequest extends FormRequest
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
        $picture = 'nullable';

        if ($this->request->get('picture', null)) {
            $picture = 'mimes:' . config('filesystems.mimes') . '|between:0,' . config('filesystems.max_size') * 1024;
        }

        // Check if store or update
        if (strtolower($this->getMethod()) == 'put') {
            $id = is_numeric($this->user) ? $this->user : $this->user->getAttribute('id');
            $required = '';
        } else {
            $id = -1;
            $required = 'required|';
        }

        return [
            'name' => 'required|string',
            'email' => 'required|email|unique:users,email,' . $id . ',id,deleted_at,NULL',
            'password' => $required . 'confirmed',
            'companies' => 'required',
            'roles' => 'required',
            'picture' => $picture,
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
