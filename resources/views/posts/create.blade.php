@extends('layouts.app')

@section('title', 'Tulis Artikel')

@section('content')
    <div class="form-page">
        <a class="back-link" href="{{ route('posts.index') }}">← Kembali ke semua artikel</a>
        <div class="form-heading">
            <p class="eyebrow">MULAI SEBUAH CERITA</p>
            <h1>Apa yang ingin<br>kamu <em>bagikan?</em></h1>
            <p>Tuangkan idemu. Cerita baik selalu menemukan pembacanya.</p>
        </div>
        <form class="post-form" method="POST" action="{{ route('posts.store') }}" novalidate>
            @csrf
            <div class="form-field">
                <label for="title">Judul artikel <span class="required-mark">*</span></label>
                <input id="title" name="title" type="text" value="{{ old('title') }}" maxlength="200" required aria-describedby="title-help title-error" placeholder="Contoh: Hal-hal kecil yang membuat hari lebih baik">
                <div class="field-foot"><small id="title-help">Maksimal 200 karakter.</small>@error('title')<small class="field-error" id="title-error">{{ $message }}</small>@enderror</div>
            </div>
            <div class="form-field">
                <label for="body">Isi cerita <span class="required-mark">*</span></label>
                <textarea id="body" name="body" rows="12" minlength="10" required aria-describedby="body-help body-error" placeholder="Mulailah menulis di sini...">{{ old('body') }}</textarea>
                <div class="field-foot"><small id="body-help">Ceritakan dengan lengkap, minimal 10 karakter.</small>@error('body')<small class="field-error" id="body-error">{{ $message }}</small>@enderror</div>
            </div>
            <div class="form-actions">
                <a class="button button-outline" href="{{ route('posts.index') }}">Batal</a>
                <button class="button button-primary" type="submit">Terbitkan artikel <span aria-hidden="true">↗</span></button>
            </div>
        </form>
    </div>
@endsection
