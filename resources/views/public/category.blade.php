@extends('public.layout')

@section('content')
    <div class="card">
        <h2>Kategori: {{ $category->name_categori }}</h2>

        @if($articles->isEmpty())
            <p>Belum ada berita di kategori ini.</p>
        @else
            <div style="display:grid; gap:16px;">
                @foreach($articles as $a)
                    <div style="border:1px solid #e2e8f0; border-radius:12px; padding:14px;">
                        <h3 style="margin-bottom:6px;"><a href="{{ url('/berita/'.$a->id) }}" style="text-decoration:none; color:#0f172a;">{{ $a->judul }}</a></h3>
                        <div class="meta">Penulis: {{ $a->reporter ? $a->reporter->nama : 'Unknown' }}</div>
                        @if($a->foto)
                            <img src="{{ asset('storage/' . $a->foto) }}" alt="Thumbnail" class="thumb">
                        @endif
                        <p style="margin: 8px 0; color:#475569;">{{ Str::limit(strip_tags($a->isi), 160) }}</p>
                        <a href="{{ url('/berita/'.$a->id) }}" class="btn">Baca selengkapnya →</a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
