<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Archivált állatok') }}
        </h2>
    </x-slot>

    <div class="py-4">
        <div class="container">
            @if(session('error'))
            <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" id="errorAlert">
                {{ session('error') }}
                <button type="button" class="btn-close" aria-label="Close" onclick="document.getElementById('errorAlert').style.display='none';"></button>
            </div>
            @endif

            <div class="card shadow">
                <div class="card-body">
                    <h3 class="fs-5 fw-semibold mb-3">Archivált állatok listája</h3>

                    @if($animals->count() > 0)
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Név</th>
                                        <th>Faj</th>
                                        <th>Archiválás időpontja</th>
                                        <th>Műveletek</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($animals as $animal)
                                        <tr>
                                            <td>{{ $animal->name }}</td>
                                            <td>{{ $animal->species }}</td>
                                            <td>{{ $animal->deleted_at->format('Y-m-d H:i:s') }}</td>
                                            <td>
                                                <button type="button" class="btn btn-primary btn-sm"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#restoreModal{{ $animal->id }}">
                                                    Visszaállítás
                                                </button>

                                                <div class="modal fade" id="restoreModal{{ $animal->id }}" tabindex="-1" aria-hidden="true">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title">Állat visszaállítása</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <form action="{{ route('animals.restore', $animal->id) }}" method="POST">
                                                                @csrf
                                                                <div class="modal-body">
                                                                    <p>Válaszd ki, melyik kifutóba szeretnéd visszahelyezni <strong>{{ $animal->name }}</strong> nevű állatot:</p>

                                                                    <div class="mb-3">
                                                                        <label for="enclosure_id_{{ $animal->id }}" class="form-label">Kifutó</label>
                                                                        <select id="enclosure_id_{{ $animal->id }}" name="enclosure_id" class="form-select" required>
                                                                            <option value="">Válassz kifutót</option>
                                                                            @foreach ($enclosures as $enclosure)
                                                                                <option value="{{ $enclosure->id }}">
                                                                                    {{ $enclosure->name }} ({{ $enclosure->animals->whereNull('deleted_at')->count() }}/{{ $enclosure->limit }} állat)
                                                                                </option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Mégsem</button>
                                                                    <button type="submit" class="btn btn-primary">Visszaállítás</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @else
                        <div class="text-center py-4 text-muted">
                            <p>Nincsenek archivált állatok.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</x-app-layout>
