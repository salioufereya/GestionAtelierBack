<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CategorieRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'libelle' => 'required | string | unique:categories|min:3',
        ];
    }
    public function messages()
    {
        return [
            'libelle.required' => 'Le libelle est obligatoire',
            'libelle.string' => 'le libelle doit etre de type chaine de caractères',
            'libelle.unique' => 'Le libelle doit etre unique',
            'libelle.min' => 'Le libelle doit etre composé de minimum de trois caractere',
        ];
    }
}
