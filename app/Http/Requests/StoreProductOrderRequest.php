<?php

namespace App\Http\Requests;

use App\Models\Product;
use App\Models\ProductOrder;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Validator;

class StoreProductOrderRequest extends FormRequest
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
        /** @var Product $product */
        $product = $this->route('product');

        return [
            'quantity' => ['required', 'integer', 'min:1', 'max:'.max(1, min(10, (int) $product->stock_quantity))],
            'client_name' => ['required', 'string', 'max:255'],
            'client_email' => ['required', 'email', 'max:255'],
            'client_phone' => ['required', 'string', 'max:30'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }

    /**
     * A client cannot order the same product again while their previous
     * order for it is still open (not served, not cancelled by the salon).
     *
     * @return array<int, callable>
     */
    public function after(): array
    {
        return [
            function (Validator $validator) {
                if ($validator->errors()->isNotEmpty()) {
                    return;
                }

                /** @var Product $product */
                $product = $this->route('product');

                $existing = ProductOrder::findOpenFor(
                    $product->id,
                    (string) $this->input('client_email'),
                    (string) $this->input('client_phone'),
                );

                if ($existing) {
                    $validator->errors()->add(
                        'client_email',
                        "Vous avez déjà une commande en cours pour « {$product->name} » (passée le {$existing->created_at->format('d/m/Y')}, statut : {$existing->statusLabel()}). "
                        .'Vous pourrez commander à nouveau ce produit une fois cette commande servie. Pour la modifier, contactez-nous.'
                    );
                }
            },
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
            'quantity.max' => 'La quantité demandée dépasse le stock disponible (:max maximum).',
            'client_name.required' => 'Merci d\'indiquer votre nom.',
            'client_email.required' => 'Merci d\'indiquer votre e-mail.',
            'client_email.email' => 'L\'adresse e-mail n\'est pas valide.',
            'client_phone.required' => 'Merci d\'indiquer votre numéro de téléphone.',
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
            'quantity' => 'quantité',
            'client_name' => 'nom',
            'client_email' => 'e-mail',
            'client_phone' => 'téléphone',
            'notes' => 'message',
        ];
    }
}
