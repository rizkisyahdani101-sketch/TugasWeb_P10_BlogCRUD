@extends('layouts.app')

@section('title', 'Edit Artikel')

@section('content')
    <div class="form-page">
        <a class="back-link" href="{{ route('posts.show', $post) }}">← Kembali ke artikel</a>
        <div class="form-heading">
            <p class="eyebrow">RUANG UNTUK MENYUNTING</p>
            <h1>Rapikan ceritamu<br>jadi <em>lebih baik.</em></h1>
            <p>Perubahan kecil bisa membuat cerita terasa lebih utuh.</p>
        </div>
        <form class="post-form" method="POST" action="{{ route('posts.update', $post) }}" novalidate>
            @csrf
            @method('PUT')
            <div class="form-field">
                <label for="title">Judul artikel <span class="required-mark">*</span></label>
                <input id="title" name="title" type="text" value="{{ old('title', $post->title) }}" maxlength="200" required aria-describedby="title-help title-error">
                <div class="field-foot"><small id="title-help">Maksimal 200 karakter.</small>@error('title')<small class="field-error" id="title-error">{{ $message }}</small>@enderror</div>
            </div>
            <div class="form-field">
                <label for="body">Isi cerita <span class="required-mark">*</span></label>
                <textarea id="body" name="body" rows="12" minlength="10" required aria-describedby="body-help body-error">{{ old('body', $post->body) }}</textarea>
                <div class="field-foot"><small id="body-help">Ceritakan dengan lengkap, minimal 10 karakter.</small>@error('body')<small class="field-error" id="body-error">{{ $message }}</small>@enderror</div>
            </div>
            <div class="form-actions">
                <a class="button button-outline" href="{{ route('posts.show', $post) }}">Batal</a>
                <button class="button button-primary" type="submit">Simpan perubahan <span aria-hidden="true">↗</span></button>
            </div>
        </form>
    </div>
@endsection
