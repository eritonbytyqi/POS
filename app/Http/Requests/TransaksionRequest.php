<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransaksionRequest extends FormRequest
{
    /**
     * Përcaktoni nëse kërkesa është e autorizuar.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;  // Sigurohuni që ky është i vërtetë për përdoruesit e mundshëm
    }

    /**
     * Përcaktoni rregullat e validimit për kërkesën.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'klient_id' => 'required' ,// Validon që klienti ekziston
            'produkt_id' => 'required', // Validon që produkti ekziston
            'Totali_Transaksionit' => 'required',  // Validon që shuma është numerike
            'Menyra_Pageses' => 'required',  // Validon që data është e vlefshme
        ];
    }
}
