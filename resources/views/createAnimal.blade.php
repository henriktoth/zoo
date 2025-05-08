<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Új állat létrehozása') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8">
                    <div class="card shadow">
                        <div class="card-body p-4">
                            @if(session('error'))
                            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" id="errorAlert">
                                {{ session('error') }}
                                <button type="button" class="btn-close" aria-label="Close" onclick="document.getElementById('errorAlert').style.display='none';"></button>
                            </div>
                            @endif
                            <form method="POST" action="{{ route('animals.store') }}" enctype="multipart/form-data">
                                @csrf

                                <div class="mb-3">
                                    <x-input-label for="name" :value="__('Állat neve')" />
                                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="species" :value="__('Faj')" />
                                    <x-text-input id="species" class="block mt-1 w-full" type="text" name="species" :value="old('species')" required />
                                    <x-input-error :messages="$errors->get('species')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="is_predator" :value="__('Ragadozó-e')" />
                                    <select id="is_predator" name="is_predator" class="form-select rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                        <option value="0" {{ old('is_predator') == '0' ? 'selected' : '' }}>Nem</option>
                                        <option value="1" {{ old('is_predator') == '1' ? 'selected' : '' }}>Igen</option>
                                    </select>
                                    <x-input-error :messages="$errors->get('is_predator')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="born_at" :value="__('Születési dátum')" />
                                    <x-text-input id="born_at" class="block mt-1 w-full" type="date" name="born_at" :value="old('born_at')" required />
                                    <x-input-error :messages="$errors->get('born_at')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="enclosure_id" :value="__('Kifutó')" />
                                    <select id="enclosure_id" name="enclosure_id" class="form-select rounded-md shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 block mt-1 w-full">
                                        <option value="">Válassz kifutót</option>
                                        @foreach ($enclosures as $enclosure)
                                            <option value="{{ $enclosure->id }}" {{ old('enclosure_id') == $enclosure->id ? 'selected' : '' }}>
                                                {{ $enclosure->name }} ({{ $enclosure->animals->count() }}/{{ $enclosure->limit }} állat)
                                            </option>
                                        @endforeach
                                    </select>
                                    <x-input-error :messages="$errors->get('enclosure_id')" class="mt-2" />
                                </div>

                                <div class="mb-3">
                                    <x-input-label for="image" :value="__('Állat képe')" />
                                    <input type="file" id="image" name="image" class="form-control mt-1 block w-full" accept="image/*">
                                    <x-input-error :messages="$errors->get('image')" class="mt-2" />
                                </div>

                                <div class="flex items-center justify-end mt-4">
                                    <a href="{{ route('list.index') }}" class="btn btn-light border me-2">
                                        Mégsem
                                    </a>
                                    <x-primary-button class="ml-4">
                                        {{ __('Létrehozás') }}
                                    </x-primary-button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
