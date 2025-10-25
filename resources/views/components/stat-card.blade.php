@props([
    'title',
    'value',
    'subtitle',
])


    <x-card cardClass="items-center justify-center">
        <h3 class="text-lg font-medium text-gray-900"> {{ $title }} </h3>
        <p class="mt-1 text-3xl text-indigo-600 font-bold"> {{ $value }} </p>
        <p class="mt-1 text-sm text-gray-500"> {{$subtitle}} </p>
    </x-card>
