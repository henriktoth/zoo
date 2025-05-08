<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kifutó hozzáadása') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    <form method="POST" action="{{ route('enclosures.store') }}">
                        @csrf

                        <div>
                            <x-input-label for="name" :value="__('Név')" />
                            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus />
                            <x-input-error :messages="$errors->get('name')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="limit" :value="__('Állat limit')" />
                            <x-text-input id="limit" class="block mt-1 w-full" type="number" name="limit" :value="old('limit')" required />
                            <x-input-error :messages="$errors->get('limit')" class="mt-2" />
                        </div>

                        <div class="mt-4">
                            <x-input-label for="feeding_at" :value="__('Etetési idő (óó:pp)')" />
                            <x-text-input id="feeding_at" class="block mt-1 w-full" type="text" name="feeding_at" :value="old('feeding_at')" required placeholder="ÓÓ:PP" />
                            <x-input-error :messages="$errors->get('feeding_at')" class="mt-2" />
                        </div>

                        <div class="flex items-center justify-end mt-4">
                            <x-primary-button class="ml-4">
                                {{ __('Hozzáadás') }}
                            </x-primary-button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="mt-4">
                <a href="{{ route('list.index') }}" class="btn btn-light border">
                    &larr; Vissza a listához
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
