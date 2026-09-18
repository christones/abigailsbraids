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
    <label for="label" class="form-label">Légende (optionnel)</label>
    <input type="text" id="label" name="label" value="{{ old('label', $image->label ?? '') }}" class="form-input mt-1" placeholder="Ex. Box braids colorées">
</div>

<div>
    <label for="image" class="form-label">Photo {{ isset($image) ? '(laisser vide pour garder la photo actuelle)' : '' }}</label>
    @if (isset($image))
        <img src="{{ asset($image->image_path) }}" alt="{{ $image->label }}" class="mt-2 h-24 w-24 rounded-lg object-cover">
    @endif
    <input type="file" id="image" name="image" accept="image/*" class="form-input mt-2">
</div>

<label class="flex items-center gap-2 text-sm text-ink-900/80">
    <input type="checkbox" name="is_active" value="1" class="rounded border-ink-900/20 text-brand-600 focus:ring-brand-500" @checked(old('is_active', $image->is_active ?? true))>
    Visible sur le site
</label>
