@props(['type' => 'success'])

<div {{ $attributes->class(['alert', 'alert-success' => $type === 'success', 'alert-error' => $type === 'error']) }} role="status">
    <span class="alert-icon" aria-hidden="true">{{ $type === 'success' ? '✓' : '!' }}</span>
    <p>{{ $slot }}</p>
</div>
