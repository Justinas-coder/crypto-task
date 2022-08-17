<?php

namespace App\Http\Requests;

use App\Models\Currency;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AssetValidationRequest extends FormRequest
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
            'title' => 'required|min:8|max:255',
            'crypto_currency' => ['required', Rule::in(Currency::get()->implode('name', ', '))],
            'quantity' => 'required|numeric|min:1',
            'paid_value' => 'required|numeric|min:1',
            'currency' => 'required',
        ];
    }
}
