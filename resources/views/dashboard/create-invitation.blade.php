@extends('layouts.app')

@section('db-page-title', 'Buat Dokumen')
@section('icon-page')
    <i class="fa-regular fa-file-lines"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item href="{{ route('create-document') }}">Buat Dokumen</x-ui.breadcrumb-item>
    <x-ui.breadcrumb-item>Buat Undangan</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col">
                <h3 class="fw-bold">Buat Undangan</h3>
                <p class="text-muted mb-0">Isi data untuk membuat undangan PDF.</p>
            </div>
        </div>

        <div class="row">
            <div class="col-12">
                <div class="card shadow-sm border-0">
                    <div class="card-body">
                        <form method="POST" action="{{ route('generate-invitation') }}">
                            @csrf

                            <div class="mb-3">
                                <label class="form-label">Nama Penerima</label>
                                <input type="text" name="recipient_name" class="form-control" required>
                                @error('recipient_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Nama Kegiatan</label>
                                <input type="text" name="event_name" class="form-control" required>
                                @error('event_name')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Deskripsi Kegiatan</label>
                                <textarea name="event_description" class="form-control" rows="3" required></textarea>
                                @error('event_description')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Tanggal</label>
                                <input type="date" name="date" class="form-control" required>
                                @error('date')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <label class="form-label">Waktu</label>
                                <input type="time" name="time" class="form-control" required>
                                @error('time')
                                <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="d-flex gap-2">
                                <button type="submit" class="btn btn-primary">
                                    Generate PDF
                                </button>
                                <a href="{{ url()->previous() }}" class="btn btn-light">
                                    Batal
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection