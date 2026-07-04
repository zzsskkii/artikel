@extends('public.layout')

@section('content')

    <div style="margin-bottom: 2rem;">
        <h2>{{ $article->judul }}</h2>
        
        <p style="color: #666; border-bottom: 1px dashed #ccc; padding-bottom: 1rem;">
            Kategori: <strong>{{ $article->category ? $article->category->name_categori : 'Uncategorized' }}</strong> | 
            Penulis: {{ $article->reporter ? $article->reporter->nama : 'Unknown' }}
        </p>

        @if($article->foto)
            <img src="{{ asset('storage/' . $article->foto) }}" alt="Foto Utama" style="max-width: 100%; height: auto; margin-bottom: 1rem;">
        @endif

        <div>
            {!! nl2br(e($article->isi)) !!}
        </div>
    </div>

    <a href="{{ url('/') }}">&laquo; Kembali ke Beranda</a>

@endsection
