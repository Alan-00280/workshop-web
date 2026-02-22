@extends('layouts.app')

@section('db-page-title', 'Buat Dokumen')
@section('icon-page')
    <i class="fa-regular fa-file-lines"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Buat Dokumen</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container py-4">
        <div class="row mb-4">
            <div class="col">
                <h3 class="fw-bold">Buat Dokumen</h3>
                <p class="text-muted mb-0">Pilih jenis dokumen yang ingin Anda generate.</p>
            </div>
        </div>

        <div class="row g-4">
            <x-docoption-card
                title="Sertifikat"
                description="Generate sertifikat berdasarkan data yang tersedia."
                :route="route('create-certificate')"
                icon="fa-solid fa-file-pdf"
            />

            <x-docoption-card
                title="Undangan"
                description="Generate undangan dalam format PDF berdasarkan kriteria tertentu."
                :route="route('create-invitation')"
                icon="fa-solid fa-file-pdf"
            />
        </div>
    </div>
@endsection