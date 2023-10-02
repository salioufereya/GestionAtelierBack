<?php

namespace App\Http\Requests;

use App\Models\Categorie;
use Illuminate\Foundation\Http\FormRequest;

class ArticleRequest extends FormRequest
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
            'libelle' => 'required |string |unique:articles|min:2',
            'prix' => 'required |numeric |min:0',
            'stock' => 'required |numeric |',
            'articleConfection' => '',
            'photo' => 'required',
            'ref' => 'required '
        ];
    }
}
