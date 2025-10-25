@props([
    'label',
    'name',
    'type' => 'text',
    'required' => false,
    'value' => '',
])

<div class="mb-4">
    <label for="{{ $name }}" class="block text-gray-700 font-semibold mb-2">{{ $label }}</label>

    <input 
        type="{{ $type }}" 
        name="{{ $name }}" 
        id="{{ $name }}"
        value="{{ old($name, $value) }}"
        @if($required) required @endif
        {{ 
            $attributes->merge([
                'class' => 
                    'w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 ' .
                    ($attributes->get('disabled') ? 'bg-gray-100 cursor-not-allowed ' : '') .
                    ($errors->has($name) ? 'border-red-500' : 'border-gray-300')
            ]) 
        }}
    >

    @error($name)
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>
