@extends('layouts.app')

@section('title', "Nouveau produit — Espace salon")

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-12 sm:px-6 lg:px-8">
        <div class="flex flex-wrap items-center justify-between gap-4">
            <div>
                <p class="section-eyebrow">Espace salon</p>
                <h1 class="section-title mt-1 text-2xl sm:text-3xl">Nouveau produit</h1>
            </div>
            <a href="{{ route('admin.products.index') }}" class="btn-secondary text-sm">Retour</a>
        </div>

        <form method="POST" action="{{ route('admin.products.store') }}" enctype="multipart/form-data" class="card mt-8 space-y-6 p-8">
            @csrf
            @include('admin.products._form')

            <button type="submit" class="btn-primary">Créer le produit</button>
        </form>
    </section>
@endsection
