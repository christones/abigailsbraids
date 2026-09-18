@if ($errors->any())
    <div class="rounded-lg bg-red-50 p-4 text-sm text-red-800 ring-1 ring-red-600/20">
        <p class="font-semibold">Merci de corriger les champs suivants :</p>
        <ul class="mt-2 list-inside list-disc">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div>
    <label for="group_label" class="form-label">Catégorie d'option</label>
    <input type="text" id="group_label" name="group_label" value="{{ old('group_label', $option->group_label ?? '') }}" class="form-input mt-1" placeholder="Ex. Longueur, Taille des tresses, Couleur, Rajouts...">
</div>

<div>
    <label for="value_label" class="form-label">Valeur</label>
    <input type="text" id="value_label" name="value_label" value="{{ old('value_label', $option->value_label ?? '') }}" class="form-input mt-1" placeholder="Ex. Mi-dos, Avec rajouts, XL...">
</div>

<div>
    <label for="extra_price" class="form-label">Supplément (€, optionnel)</label>
    <input type="number" id="extra_price" name="extra_price" min="0" step="0.01" value="{{ old('extra_price', $option->extra_price ?? '') }}" class="form-input mt-1">
</div>

<label class="flex items-center gap-2 text-sm text-ink-900/80">
    <input type="checkbox" name="is_active" value="1" class="rounded border-ink-900/20 text-brand-600 focus:ring-brand-500" @checked(old('is_active', $option->is_active ?? true))>
    Visible sur le site
</label>
