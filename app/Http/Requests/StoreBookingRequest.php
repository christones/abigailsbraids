<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBookingRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'service_id' => ['required', 'integer', 'exists:services,id'],
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['required', 'email', 'max:255'],
            'client_phone' => ['required', 'string', 'max:30'],
            'preferred_date' => ['required', 'date', 'after_or_equal:tomorrow'],
            'preferred_time' => ['required', 'string', 'in:09:00,10:30,13:00,14:30,16:00,17:30'],
            'hair_length' => ['nullable', 'string', 'max:100'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * Get custom messages for validator errors, in French.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'service_id.required' => 'Merci de choisir une prestation.',
            'service_id.exists' => 'La prestation sélectionnée n\'est pas valide.',
            'client_name.required' => 'Merci d\'indiquer votre nom.',
            'client_email.required' => 'Merci d\'indiquer votre e-mail.',
            'client_email.email' => 'L\'adresse e-mail n\'est pas valide.',
            'client_phone.required' => 'Merci d\'indiquer votre numéro de téléphone.',
            'preferred_date.required' => 'Merci de choisir une date.',
            'preferred_date.after_or_equal' => 'Merci de choisir une date à partir de demain.',
            'preferred_time.required' => 'Merci de choisir un créneau horaire.',
            'preferred_time.in' => 'Merci de choisir un créneau horaire proposé.',
        ];
    }

    /**
     * Get custom attribute names, in French, for error messages.
     *
     * @return array<string, string>
     */
    public function attributes(): array
    {
        return [
            'service_id' => 'prestation',
            'client_name' => 'nom',
            'client_email' => 'e-mail',
            'client_phone' => 'téléphone',
            'preferred_date' => 'date',
            'preferred_time' => 'heure',
            'hair_length' => 'longueur de cheveux',
            'notes' => 'notes',
        ];
    }
}
