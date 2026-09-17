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
    <input type="text" id="name" name="name" value="{{ old('name', $category->name ?? '') }}" class="form-input mt-1" placeholder="Ex. Tresses collées">
</div>

<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <label for="sort_order" class="form-label">Ordre d'affichage</label>
        <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $category->sort_order ?? 0) }}" class="form-input mt-1">
    </div>
    <label class="mt-1 flex items-center gap-2 text-sm text-ink-900/80 sm:mt-8">
        <input type="checkbox" name="is_active" value="1" class="rounded border-ink-900/20 text-brand-600 focus:ring-brand-500" @checked(old('is_active', $category->is_active ?? true))>
        Visible sur le site
    </label>
</div>
