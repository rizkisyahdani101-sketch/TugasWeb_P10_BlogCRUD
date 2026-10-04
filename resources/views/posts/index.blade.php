@extends('layouts.app')

@section('title', 'Semua Artikel')

@section('content')
    <section class="hero">
        <div class="hero-copy">
            <p class="eyebrow"><span class="eyebrow-line"></span> RUANG UNTUK BERTUMBUH</p>
            <h1>Setiap cerita<br>punya <em>tempatnya.</em></h1>
            <p class="hero-description">Kumpulan gagasan, pengalaman, dan cerita kecil yang layak dibagikan.</p>
            <a class="button button-dark" href="{{ route('posts.create') }}">Mulai menulis <span aria-hidden="true">↗</span></a>
        </div>
        <div class="hero-art" aria-hidden="true">
            <div class="sun"></div><div class="art-ring ring-one"></div><div class="art-ring ring-two"></div>
            <div class="art-note"><span>CATATAN HARI INI</span><strong>“Mulai saja<br>dari satu kata.”</strong><i>— ruangkata</i></div>
            <span class="art-spark spark-one">✳</span><span class="art-spark spark-two">✳</span>
        </div>
    </section>

    <section class="posts-section" aria-labelledby="posts-heading">
        <div class="section-heading">
            <div><p class="eyebrow">DARI MEJA REDAKSI</p><h2 id="posts-heading">Cerita terbaru <span class="count-badge">{{ $posts->total() }}</span></h2></div>
            <a class="text-link" href="{{ route('posts.create') }}">Tulis cerita <span aria-hidden="true">↗</span></a>
        </div>

        @forelse ($posts as $post)
            @if ($loop->first)
                <div class="post-grid">
            @endif
            <x-card :post="$post" />
            @if ($loop->last)
                </div>
            @endif
        @empty
            <div class="empty-state">
                <span class="empty-icon" aria-hidden="true">✎</span>
                <h3>Halaman pertama masih kosong.</h3>
                <p>Setiap blog dimulai dari satu cerita. Bagikan ceritamu sekarang.</p>
                <a class="button button-primary" href="{{ route('posts.create') }}">Buat artikel pertama</a>
            </div>
        @endforelse

        @if ($posts->hasPages())
            <div class="pagination-wrap">{{ $posts->links() }}</div>
        @endif
    </section>
@endsection
