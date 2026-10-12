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
    <label for="name" class="form-label">Nom de la catégorie</label>
    <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" class="form-input mt-1" placeholder="Ex. Soins & huiles">
</div>

<div>
    <label for="description" class="form-label">Courte description (optionnel)</label>
    <textarea id="description" name="description" rows="2" class="form-input mt-1" placeholder="Ex. Huiles et soins pour nourrir le cuir chevelu entre deux coiffures.">{{ old('description', $category->description ?? '') }}</textarea>
</div>

<div>
    <label for="image" class="form-label">Photo {{ isset($category) && $category->image_path ? '(laisser vide pour garder la photo actuelle)' : '(optionnel)' }}</label>
    @if (isset($category) && $category->image_path)
        <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}" class="mt-2 h-24 w-32 rounded-lg object-cover">
        <img src="{{ asset($category->image_path) }}" alt="{{ $category->name }}" class="mt-2 h-24 w-24 rounded-lg object-cover">
    @endif
    <input type="file" id="image" name="image" accept="image/*" class="form-input mt-2">
    <p class="mt-1 text-xs text-ink-900/50">Affichée sur la page d'accueil. Sans photo, celle du premier produit de la catégorie est utilisée.</p>
</div>

<label class="flex items-center gap-2 text-sm text-ink-900/80">
    <input type="checkbox" name="is_active" value="1" class="rounded border-ink-900/20 text-brand-600 focus:ring-brand-500" @checked(old('is_active', $category->is_active ?? true))>
    Visible sur le site
</label>
