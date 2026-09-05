<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTrainingRegistrationRequest extends FormRequest
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
            'training_id' => ['required', 'integer', 'exists:trainings,id'],
            'candidate_name' => ['required', 'string', 'max:255'],
            'candidate_email' => ['required', 'email', 'max:255'],
            'candidate_phone' => ['required', 'string', 'max:30'],
            'preferred_date' => ['required', 'date', 'after_or_equal:tomorrow'],
            'experience_level' => ['nullable', 'string', 'max:100'],
            'message' => ['nullable', 'string', 'max:1000'],
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
            'training_id.required' => 'Merci de choisir une formation.',
            'training_id.exists' => 'La formation sélectionnée n\'est pas valide.',
            'candidate_name.required' => 'Merci d\'indiquer votre nom.',
            'candidate_email.required' => 'Merci d\'indiquer votre e-mail.',
            'candidate_email.email' => 'L\'adresse e-mail n\'est pas valide.',
            'candidate_phone.required' => 'Merci d\'indiquer votre numéro de téléphone.',
            'preferred_date.required' => 'Merci de choisir une date.',
            'preferred_date.after_or_equal' => 'Merci de choisir une date à partir de demain.',
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
            'training_id' => 'formation',
            'candidate_name' => 'nom',
            'candidate_email' => 'e-mail',
            'candidate_phone' => 'téléphone',
            'preferred_date' => 'date',
            'experience_level' => 'niveau',
            'message' => 'message',
        ];
    }
}
