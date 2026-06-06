@props([
    'code' => '',
])

<div class="overflow-hidden" id="{{ $code }}-table">
    <table class="table">
        {{ $slot }}
    </table>
</div>
