@php
    $cover = $category->coverImagePath();
@endphp

<a
    href="{{ route('products.index', ['categorie' => $category->slug]) }}"
    class="group card card-hover relative block overflow-hidden"
>
    <img
        src="{{ $cover ? asset($cover) : 'https://placehold.co/480x600/faeadb/863f1f?text='.urlencode($category->name) }}"
        alt="{{ $category->name }}"
        class="h-64 w-full object-cover transition duration-500 group-hover:scale-105"
        loading="lazy"
    >
    <div class="absolute inset-0 bg-gradient-to-t from-ink-900/85 via-ink-900/30 to-transparent"></div>
    <div class="absolute inset-x-0 bottom-0 p-5 text-white">
        <h3 class="font-serif text-xl font-semibold">{{ $category->name }}</h3>
        @if ($category->description)
            <p class="mt-1 text-sm text-white/80">{{ \Illuminate\Support\Str::limit($category->description, 70) }}</p>
        @endif
        <p class="mt-3 inline-flex items-center gap-1 text-sm font-semibold text-brand-200">
            {{ $category->products_count }} {{ $category->products_count > 1 ? 'produits' : 'produit' }}
            <span class="transition group-hover:translate-x-1" aria-hidden="true">&rarr;</span>
        </p>
    </div>
</a>
