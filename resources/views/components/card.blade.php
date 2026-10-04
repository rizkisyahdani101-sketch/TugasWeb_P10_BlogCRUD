@props(['post'])

<article {{ $attributes->class(['post-card']) }}>
    <div class="card-meta">
        <span class="category-pill">Catatan</span>
        <time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->translatedFormat('d F Y') }}</time>
    </div>
    <h2 class="card-title"><a href="{{ route('posts.show', $post) }}">{{ $post->title }}</a></h2>
    <p class="card-excerpt">{{ \Illuminate\Support\Str::limit(strip_tags($post->body), 150) }}</p>
    <div class="card-footer">
        <a class="text-link" href="{{ route('posts.show', $post) }}">Baca artikel <span aria-hidden="true">→</span></a>
        <div class="card-actions">
            <a class="icon-link" href="{{ route('posts.edit', $post) }}" aria-label="Edit {{ $post->title }}">Edit</a>
            <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                @csrf
                @method('DELETE')
                <button class="icon-button danger-link" type="submit">Hapus</button>
            </form>
        </div>
    </div>
</article>
