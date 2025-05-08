<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Főoldal
        </h2>
    </x-slot>

    <div class="py-4 container">
        <div class="row justify-content-center mb-4">
            <div class="col-md-10">
                <h1 class="display-5 fw-bold text-center mb-4">
                    Üdvözöljük, <span class="text-primary">{{ Auth::user()->name }}</span>
                </h1>
            </div>
        </div>

        <div class="row justify-content-center mb-4">
            <div class="col-md-5 mb-3 mb-md-0">
                <div class="card shadow border-0 bg-gradient"
                    style="background: linear-gradient(135deg, #e0f7fa 0%, #b2dfdb 100%);">
                    <div class="card-body d-flex flex-column align-items-center py-4">
                        <h6 class="card-subtitle mb-1 text-muted">Kifutók száma</h6>
                        <h2 class="fw-bold text-success mb-0">{{ $enclosuresCount }}</h2>
                    </div>
                </div>
            </div>
            <div class="col-md-5">
                <div class="card shadow border-0 bg-gradient"
                    style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);">
                    <div class="card-body d-flex flex-column align-items-center py-4">
                        <h6 class="card-subtitle mb-1 text-muted">Állatok száma</h6>
                        <h2 class="fw-bold text-primary mb-0">{{ $animalsCount }}</h2>
                    </div>
                </div>
            </div>
        </div>

        <div class="row justify-content-center">
            <div class="col-md-10">
                <div class="card shadow-lg border-0"
                    style="background: linear-gradient(120deg, #e3f0ff 0%, #f9fafc 100%);">
                    <div class="card-header d-flex align-items-center justify-content-between"
                        style="background: linear-gradient(90deg, #1976d2 0%, #64b5f6 100%); border-top-left-radius: .5rem; border-top-right-radius: .5rem;">
                        <h5 class="mb-0 text-white fw-bold">
                            <i class="bi bi-calendar2-check me-2"></i>Mai etetési feladatok
                        </h5>
                        <span class="badge bg-light text-primary fs-6">{{ $feedings->count() }} feladat</span>
                    </div>
                    <div class="card-body p-0">
                        @if ($feedings->count() > 0)
                            <div class="list-group list-group-flush">
                                @foreach ($feedings as $enclosure)
                                    <div class="list-group-item d-flex align-items-center justify-content-between py-4 px-3 mb-3 shadow-sm"
                                        style="background: linear-gradient(90deg, #f5fafd 0%, #e3f0ff 100%); border-radius: 1rem; border: 1px solid #e3f2fd;">
                                        <div class="d-flex align-items-center">
                                            <div>
                                                <div class="fw-bold fs-5 text-dark mb-1">
                                                    {{ $enclosure->name }}
                                                </div>
                                                <div class="text-muted small">Kifutó</div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <span class="badge px-4 py-2"
                                                style="background: linear-gradient(90deg, #43e97b 0%, #38f9d7 100%); color: #155724; font-size: 1.1rem; border-radius: 1rem;">
                                                <i class="bi bi-clock me-1"></i>
                                                {{ $enclosure->feeding_at }}
                                            </span>
                                            <div class="text-muted small mt-2">Etetési idő</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="alert alert-info d-flex align-items-center justify-content-center mb-0 py-5"
                                role="alert" style="border-radius: 1rem;">
                                <i class="bi bi-emoji-smile fs-2 me-3"></i>
                                <span class="fw-medium fs-5">Nincs több etetési feladat a mai napra.</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
