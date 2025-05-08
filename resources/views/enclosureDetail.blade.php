<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Kifutó részletei') }}
        </h2>
    </x-slot>
    <div class="container mt-5">
        @if(session('success'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" id="successAlert">
            {{ session('success') }}
            <button type="button" class="btn-close" aria-label="Close" onclick="document.getElementById('successAlert').style.display='none';"></button>
        </div>
    @endif
    </div>
    <div class="py-4">
        <div class="container">
            <div class="card mb-4 shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <h3 class="fs-3 fw-bold mb-0">{{ $enclosure->name }}</h3>

                        @if($hasPredators)
                        <div class="alert alert-danger d-flex align-items-center mb-0 py-2 px-3" role="alert">
                            <svg xmlns="http://www.w3.org/2000/svg" class="me-2" width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" />
                            </svg>
                            <span class="fw-medium">Figyelem! Ebben a kifutóban ragadozó állatok vannak!</span>
                        </div>
                        @endif
                    </div>

                    <div class="row mb-4">
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="bg-light p-3 rounded">
                                <div class="text-muted mb-1">Állat limit</div>
                                <div class="fs-5 fw-semibold">{{ $enclosure->limit }}</div>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="bg-light p-3 rounded">
                                <div class="text-muted mb-1">Jelenlegi állatszám</div>
                                <div class="fs-5 fw-semibold">{{ $animals->count() }} / {{ $enclosure->limit }}</div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-4">
                        <h4 class="fs-5 fw-semibold mb-3">Etetési idő</h4>
                        <span class="badge bg-success d-inline-flex align-items-center fs-6 py-2 px-3">
                            <svg class="me-2" width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            {{ $enclosure->feeding_at }}
                        </span>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <h3 class="fs-4 fw-semibold mb-3">Állatok a kifutóban</h3>

                    @if($animals->count() > 0)
                        <div class="row g-3">
                            @foreach($animals as $animal)
                                <div class="col-12 col-md-6 col-lg-4">
                                    <div class="card h-100 border-0 shadow-sm">
                                        <div class="bg-light" style="height: 200px; overflow: hidden;">
                                            @if($animal->image)
                                                <img src="{{ $animal->image }}" alt="{{ $animal->name }}" class="img-thumbnail">
                                            @else
                                                <img src="{{ asset('images/placeholder.png') }}" alt="Placeholder" class="img-thumbnail">
                                            @endif
                                        </div>
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <h4 class="fs-5 fw-semibold mb-0">{{ $animal->name }}</h4>
                                                @if($animal->is_predator)
                                                    <span class="badge bg-danger">Ragadozó</span>
                                                @endif
                                            </div>
                                            <p class="text-muted mb-1">{{ $animal->species }}</p>
                                            <p class="text-secondary small mb-2">Született: {{ \Carbon\Carbon::parse($animal->born_at)->format('Y-m-d') }}</p>

                                            <div class="mt-2 d-flex gap-2">
                                                @can('edit-animals')
                                                    <a href="{{ route('animals.edit', $animal->id) }}" class="btn btn-warning btn-sm">Szerkesztés</a>
                                                @endcan

                                                @can('archive-animals')
                                                <form action="{{ route('animals.archive', $animal->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary btn-sm"
                                                            onclick="return confirm('Biztosan archiválni szeretnéd ezt az állatot?')">
                                                        Archiválás
                                                    </button>
                                                </form>
                                                @endcan
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div class="text-center py-5 text-muted">
                            <p>Ebben a kifutóban jelenleg nincs állat.</p>
                        </div>
                    @endif
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
