@if(isset($categories) && $categories->count())
    @foreach($categories as $cat)
        <a href="{{ url('/kategori/'.$cat->id) }}">{{ $cat->name_categori }}</a>
    @endforeach
@else
    <a href="{{ url('/') }}">Beranda</a>
@endif
