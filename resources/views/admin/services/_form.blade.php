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
    <label for="name" class="form-label">Nom de la prestation</label>
    <input type="text" id="name" name="name" value="{{ old('name', $service->name ?? '') }}" class="form-input mt-1" placeholder="Ex. Box Braids">
</div>

<div>
    <label for="service_category_id" class="form-label">Catégorie</label>
    <select id="service_category_id" name="service_category_id" class="form-input mt-1">
        <option value="">-- Non classée --</option>
        @foreach ($categories as $category)
            <option
                value="{{ $category->id }}"
                @selected((int) old('service_category_id', $service->service_category_id ?? '') === $category->id)
            >
                {{ $category->name }}
            </option>
        @endforeach
    </select>
    <p class="mt-1 text-xs text-ink-900/50">
        <a href="{{ route('admin.service-categories.index') }}" class="text-brand-700 hover:text-brand-800">Gérer les catégories</a>
    </p>
</div>

<div>
    <label for="description" class="form-label">Description</label>
    <textarea id="description" name="description" rows="3" class="form-input mt-1">{{ old('description', $service->description ?? '') }}</textarea>
</div>

<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <label for="duration_minutes" class="form-label">Durée (minutes)</label>
        <input type="number" id="duration_minutes" name="duration_minutes" min="15" step="15" value="{{ old('duration_minutes', $service->duration_minutes ?? 120) }}" class="form-input mt-1">
    </div>
    <div>
        <label for="price_from" class="form-label">Prix à partir de (€)</label>
        <input type="number" id="price_from" name="price_from" min="0" step="0.01" value="{{ old('price_from', $service->price_from ?? '') }}" class="form-input mt-1">
    </div>
</div>

<div>
    <label for="image" class="form-label">Photo {{ isset($service) && $service->image_path ? '(laisser vide pour garder la photo actuelle)' : '(optionnel)' }}</label>
    @if (isset($service) && $service->image_path)
        <img src="{{ asset($service->image_path) }}" alt="{{ $service->name }}" class="mt-2 h-24 w-24 rounded-lg object-cover">
    @endif
    <input type="file" id="image" name="image" accept="image/*" class="form-input mt-2">
</div>

<div class="grid gap-6 sm:grid-cols-2">
    <div>
        <label for="sort_order" class="form-label">Ordre d'affichage</label>
        <input type="number" id="sort_order" name="sort_order" min="0" value="{{ old('sort_order', $service->sort_order ?? 0) }}" class="form-input mt-1">
    </div>
    <label class="mt-1 flex items-center gap-2 text-sm text-ink-900/80 sm:mt-8">
        <input type="checkbox" name="is_active" value="1" class="rounded border-ink-900/20 text-brand-600 focus:ring-brand-500" @checked(old('is_active', $service->is_active ?? true))>
        Visible sur le site
    </label>
</div>

@if (isset($service))
    <div class="rounded-lg bg-brand-50 p-4 text-sm text-ink-900/70">
        Options et variantes (longueur, rajouts, couleurs...) :
        <a href="{{ route('admin.services.options.index', $service) }}" class="font-medium text-brand-700 hover:text-brand-800">gérer les options de cette prestation</a>
    </div>
@endif
