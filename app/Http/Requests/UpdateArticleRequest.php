<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateArticleRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'judul' => 'required|string|max:255',
            'posisi' => 'nullable|string',
            'isi' => 'required|string',
            'reporter' => 'required|string',
            'kategori_id' => 'required|exists:categories,id',
            'foto' => 'nullable|image|max:2048',
        ];
    }
}