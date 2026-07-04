@extends('public.layout')

@section('content')

    <h2>Kategori: {{ $category->name_categori }}</h2>

    @if($articles->isEmpty())
        <p>Belum ada berita di kategori ini.</p>
    @else
        <ul style="list-style-type: none; padding: 0;">
            @foreach($articles as $a)
                <li style="margin-bottom: 2rem; border-bottom: 1px dashed #ccc; padding-bottom: 1rem;">
                    <h3><a href="{{ url('/berita/'.$a->id) }}">{{ $a->judul }}</a></h3>
                    <p style="font-size: 0.9em; color: #666;">
                        Penulis: {{ $a->reporter ? $a->reporter->nama : 'Unknown' }}
                    </p>
                    @if($a->foto)
                        <img src="{{ asset('storage/' . $a->foto) }}" alt="Thumbnail" style="max-width: 200px; display: block; margin-bottom: 1rem;">
                    @endif
                    <p>{{ Str::limit(strip_tags($a->isi), 150) }}</p>
                    <a href="{{ url('/berita/'.$a->id) }}">Baca selengkapnya...</a>
                </li>
            @endforeach
        </ul>
    @endif

@endsection
