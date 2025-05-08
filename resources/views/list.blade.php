<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-semibold fs-4 text-dark">
            {{ __('Kifutók listája') }}
        </h2>
    </x-slot>
    <div class="py-4">
        <div class="container">
            <div class="card shadow-sm rounded p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" id="successAlert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" aria-label="Close" onclick="document.getElementById('successAlert').style.display='none';"></button>
                    </div>
                @endif
                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" id="errorAlert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" aria-label="Close" onclick="document.getElementById('errorAlert').style.display='none';"></button>
                    </div>
                @endif
                <table class="table table-striped table-bordered align-middle">
                    <thead class="table-light">
                        <tr>
                            <th>Kifutó neve</th>
                            <th>Állat limit</th>
                            <th>Jelenlegi állatszám</th>
                            <th>Műveletek</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($enclosures->values() as $index => $enclosure)
                            <tr>
                                <td>{{ $enclosure->name }}</td>
                                <td>{{ $enclosure->limit }}</td>
                                <td>{{ $enclosure->animals_count }}</td>
                                <td>
                                    <div class="d-flex justify-content-center">
                                        <div class="btn-group" role="group">
                                            <a href="{{ route('enclosures.show', $enclosure->id) }}" class="btn btn-info text-white flex-fill rounded-pill mx-2" style="min-width: 120px;">Megjelenítés</a>
                                            @can('modify-enclosures')
                                                <a href="{{ route('enclosures.edit', $enclosure->id) }}" class="btn btn-warning text-dark flex-fill rounded-pill mx-2" style="min-width: 120px;">Szerkesztés</a>
                                                <form action="{{ route('enclosures.delete', $enclosure->id) }}" method="POST" onsubmit="return confirm('Biztosan törlöd ezt a kifutót?');" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger flex-fill rounded-pill mx-2" style="min-width: 120px;">
                                                        Törlés
                                                    </button>
                                                </form>
                                            @endcan
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @can('modify-enclosures')
                    <div class="d-flex justify-content-begin mb-3">
                        <a href="{{ route('enclosures.create') }}" class="btn btn-success rounded-pill">
                            Új kifutó hozzáadása
                        </a>
                    </div>
                @endcan
                <div class="mt-3">
                    {{ $enclosures->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
