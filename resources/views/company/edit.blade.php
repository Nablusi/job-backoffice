<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Edit Company {{ $company->name }}
        </h2>
    </x-slot>

    <div class="overflow-x-auto p-6">

        <!-- company Creation Form -->
        <form method="POST" action="{{ route(auth()->user()->role == 'admin' ? 'companies.update' : 'my-company.update' , $company->id) }}"
            class="max-w-md mx-auto bg-white p-6 rounded-lg shadow">
            @method('PUT')
            @csrf
             <input type="hidden" name="redirectToList" value="{{ $redirectToList }}">
            <!-- company Details -->
            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold"> Company Details </h3>
                <p class="text-sm mb-4"> Enter the company details </p>
                <x-input-field label="Company Name" name="name" value="{{ old('name', $company->name) }}" />
                <x-input-field label="Address" name="address" value="{{ old('name', $company->address) }}"  />

                <div class="mb-4">
                    <label for="industry" class="block text-sm font-medium text-gray-700"> Industry </label>
                    <select name="industry" id="industry" value="{{ old('industry', $company->industry) }}" 
                        class="mt-1 block w-full rounded-md shadow-sm border-gray-300 focus:border-indigo-500">
                        @foreach ($industries as $industry)
                            <option value="{{ $industry }}" > {{ $industry }} </option>
                        @endforeach
                    </select>
                </div>
                <x-input-field label="Website (optional)" name="website" type="url" value="{{ old('website', $company->website) }}"  />
            </div>


            <!-- Company Owner -->

            <div class="mb-4 p-6 bg-gray-50 border-gray-100 rounded-lg shadow-sm">
                <h3 class="text-lg font-bold" > Company Owner </h3>
                <p class="text-sm mb-4"> Enter the owner details </p>
                <x-input-field label="Company Owner Name" name="owner_name"  value="{{ old('owner_name', $company->owner->name) }}"  />
                
                <!-- readonly can not be changed -->
                <x-input-field disabled label="Owner email" name="owner_email" value="{{ old('owner_email', $company->owner->email) }}"  />

                <!-- Password -->
                <div class="mt-4 relative" x-data="{ showPassword: false }">
                    <x-input-label for="owner_password" :value="__('change owner password (leave blank to be the same)')"   />

                    <x-text-input id="owner_password" class="block mt-1 w-full" name="owner_password"   
                        autocomplete="current-password" x-bind:type="showPassword ? 'text' : 'password'" />

                    <button @click="showPassword = !showPassword" class="absolute flex items-center text-grey-500"
                        type="button" style="top:34px ; right: 5px;">
                        <svg x-show="!showPassword" class="w-5 h-5" width="800px" height="800px" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15.0007 12C15.0007 13.6569 13.6576 15 12.0007 15C10.3439 15 9.00073 13.6569 9.00073 12C9.00073 10.3431 10.3439 9 12.0007 9C13.6576 9 15.0007 10.3431 15.0007 12Z"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                            <path
                                d="M12.0012 5C7.52354 5 3.73326 7.94288 2.45898 12C3.73324 16.0571 7.52354 19 12.0012 19C16.4788 19 20.2691 16.0571 21.5434 12C20.2691 7.94291 16.4788 5 12.0012 5Z"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>


                        <svg x-show="showPassword" class="w-5 h-5" width="800px" height="800px" viewBox="0 0 24 24"
                            fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M2.99902 3L20.999 21M9.8433 9.91364C9.32066 10.4536 8.99902 11.1892 8.99902 12C8.99902 13.6569 10.3422 15 11.999 15C12.8215 15 13.5667 14.669 14.1086 14.133M6.49902 6.64715C4.59972 7.90034 3.15305 9.78394 2.45703 12C3.73128 16.0571 7.52159 19 11.9992 19C13.9881 19 15.8414 18.4194 17.3988 17.4184M10.999 5.04939C11.328 5.01673 11.6617 5 11.9992 5C16.4769 5 20.2672 7.94291 21.5414 12C21.2607 12.894 20.8577 13.7338 20.3522 14.5"
                                stroke="#000000" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>

                    </button>

                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>


            </div>


            <div class="flex flex-row flex-wrap gap-3 items-center justify-end">
                <a href="{{ route(auth()->user()->role == 'admin' ? 'companies.index' : 'my-company.show') }}" class="text-grey-500 hover:text-grey-700 ">←
                    Cancel
                </a>
                <div class="flex justify-end">
                    <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-600">Update
                        company
                    </button>
                </div>

            </div>
        </form>

    </div>

</x-app-layout>