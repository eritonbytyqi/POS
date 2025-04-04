<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RaporteShitjeshRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
'data_raportit' => 'required|date',

            'user_id' => 'required|exists:users,id',

            'shuma_totale_shitjesh' => 'required|numeric|min:0',

            'shuma_zbritjesh' => 'required|numeric|min:0',

            'numri_transaksioneve' => 'required|integer|min:1',

            'status_raporti' => 'required|in:generuar,ne_pritje,finalizuar',
                ];
    }
}
