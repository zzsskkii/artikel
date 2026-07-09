@extends('public.layout')

@section('content')
    <div class="card">
        <h2>{{ $article->judul }}</h2>

        <div class="meta" style="border-bottom:1px solid #e2e8f0; padding-bottom:10px; margin-bottom:12px;">
            Kategori: <strong>{{ $article->category ? $article->category->name_categori : 'Uncategorized' }}</strong> |
            Penulis: {{ $article->reporter ? $article->reporter->nama : 'Unknown' }}
        </div>

        @if($article->foto)
            <img src="{{ asset('storage/' . $article->foto) }}" alt="Foto Utama" style="max-width: 100%; height: auto; border-radius: 12px; margin-bottom: 14px;">
        @endif

        <div style="line-height: 1.7; color:#334155;">
            {!! $article->isi !!}
        </div>

        <a href="{{ url('/') }}" class="btn">&laquo; Kembali ke Beranda</a>
    </div>
@endsection
