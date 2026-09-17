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
    <label for="name" class="form-label">Nom de la formation</label>
    <input type="text" id="name" name="name" value="{{ old('name', $training->name ?? '') }}" class="form-input mt-1" placeholder="Ex. Initiation aux tresses">
</div>

<div>
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" rows="3" class="form-input mt-1">{{ old('description', $training->description ?? '') }}</textarea>
</div>

<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <label for="level" class="form-label">Niveau</label>
        <input type="text" id="level" name="level" value="{{ old('level', $training->level ?? '') }}" class="form-input mt-1" placeholder="Ex. Débutant">
    </div>
    <div>
        <label for="duration_minutes" class="form-label">Durée (minutes)</label>
        <input type="number" id="duration_minutes" name="duration_minutes" min="15" step="15" value="{{ old('duration_minutes', $training->duration_minutes ?? 360) }}" class="form-input mt-1">
    </div>
</div>

<div>
    <label for="price_from" class="form-label">Prix à partir de (€)</label>
    <input type="number" id="price_from" name="price_from" min="0" step="0.01" value="{{ old('price_from', $training->price_from ?? '') }}" class="form-input mt-1">
</div>

<div>
    <label for="image" class="form-label">Photo {{ isset($training) && $training->image_path ? '(laisser vide pour garder la photo actuelle)' : '(optionnel)' }}</label>
    @if (isset($training) && $training->image_path)
        <img src="{{ asset($training->image_path) }}" alt="{{ $training->name }}" class="mt-2 h-24 w-24 rounded-lg object-cover">
    @endif
    <input type="file" id="image" name="image" accept="image/*" class="form-input mt-2">
</div>

<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <label for="sort_order" class="form-label">Ordre d'affichage</label>
        <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $training->sort_order ?? 0) }}" class="form-input mt-1">
    </div>
    <label class="mt-1 flex items-center gap-2 text-sm text-ink-900/80 sm:mt-8">
        <input type="checkbox" name="is_active" value="1" class="rounded border-ink-900/20 text-brand-600 focus:ring-brand-500" @checked(old('is_active', $training->is_active ?? true))>
        Visible sur le site
    </label>
</div>
