@props([
    'cardClass' => ''
])

<div class="bg-white overflow-hidden shadow-sm sm:rounded-lg flex flex-col gap-3 p-6 {{ $cardClass }} ">
    {{ $slot }}
</div>