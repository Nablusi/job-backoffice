<div class="mb-4">
    <label for="name" class="block text-gray-700 font-semibold mb-2">Category Name:</label>
    <input type="text" name="name" id="name"
        class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-600 {{ $errors->has('name') ? 'border-red-500' : 'border-gray-300' }}"
        required value="{{ old('name') }}">
    @error('name')
        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>