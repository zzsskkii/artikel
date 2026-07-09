@extends('public.layout')

@section('content')
<div style="display: flex; gap: 24px; flex-wrap: wrap;">
    <div style="flex: 3; min-width: 300px;">
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
            <!-- Pagination -->
            <div style="display: flex; justify-content: space-between; margin-top: 24px; padding-top: 16px; border-top: 1px solid #e2e8f0;">
                @if($articles->onFirstPage())
                    <span class="btn-light" style="opacity: 0.5; cursor: not-allowed;">&laquo; Sebelumnya</span>
                @else
                    <a href="{{ $articles->previousPageUrl() }}" class="btn-light">&laquo; Sebelumnya</a>
                @endif

                <span style="align-self: center; color: #64748b; font-size: 14px;">Halaman {{ $articles->currentPage() }} dari {{ $articles->lastPage() }}</span>

                @if($articles->hasMorePages())
                    <a href="{{ $articles->nextPageUrl() }}" class="btn-light">Selanjutnya &raquo;</a>
                @else
                    <span class="btn-light" style="opacity: 0.5; cursor: not-allowed;">Selanjutnya &raquo;</span>
                @endif
            </div>
        @endif
        </div>
    </div>

    <!-- Sidebar Populer -->
    <div style="flex: 1; min-width: 250px;">
        <div class="card">
            <h2 style="font-size: 18px; margin-bottom: 16px;">🔥 Berita Terpopuler</h2>
            @if(isset($popularArticles) && $popularArticles->isEmpty())
                <p style="font-size: 14px; color: #64748b;">Belum ada berita terpopuler.</p>
            @elseif(isset($popularArticles))
                <div style="display: flex; flex-direction: column; gap: 12px;">
                    @foreach($popularArticles as $pa)
                        <div style="border-bottom: 1px solid #f1f5f9; padding-bottom: 10px;">
                            <a href="{{ url('/berita/'.$pa->id) }}" style="text-decoration:none; color:#0f172a; font-weight: bold; font-size: 14px; line-height: 1.4; display: block;">{{ $pa->judul }}</a>
                            <div style="font-size: 12px; color: #64748b; margin-top: 6px; display: flex; justify-content: space-between;">
                                <span>{{ $pa->category ? $pa->category->name_categori : 'Umum' }}</span>
                                <span style="color: #ef4444; font-weight: bold;">{{ $pa->views }}x dibaca</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
