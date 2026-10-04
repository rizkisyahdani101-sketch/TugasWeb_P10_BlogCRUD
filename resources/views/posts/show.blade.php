@extends('layouts.app')

@section('title', $post->title)

@section('content')
    <article class="article-page">
        <a class="back-link" href="{{ route('posts.index') }}">← Kembali ke semua artikel</a>
        <header class="article-header">
            <div class="card-meta"><span class="category-pill">Catatan</span><time datetime="{{ $post->created_at->toDateString() }}">{{ $post->created_at->translatedFormat('d F Y') }}</time></div>
            <h1>{{ $post->title }}</h1>
            <p class="article-byline">Sebuah cerita dari ruangkata · {{ $post->created_at->diffForHumans() }}</p>
        </header>
        <div class="article-body">{{ $post->body }}</div>
        <div class="article-actions">
            <a class="button button-outline" href="{{ route('posts.edit', $post) }}">Edit artikel</a>
            <form method="POST" action="{{ route('posts.destroy', $post) }}" onsubmit="return confirm('Yakin ingin menghapus artikel ini?')">
                @csrf
                @method('DELETE')
                <button class="button button-danger" type="submit">Hapus artikel</button>
            </form>
        </div>
    </article>
@endsection
