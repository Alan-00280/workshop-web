@extends('layouts.app')

@section('db-page-title', 'Daftar Mahasiswa')
@section('icon-page')
    <i class="fa-solid fa-graduation-cap"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Daftar Mahasiswa</x-ui.breadcrumb-item>
@endsection

@section('content')
    <!-- Button Group / Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('create-student') }}" class="btn btn-gradient-primary btn-icon-text font-weight-medium shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Tambah Siswa
        </a>
    </div>

    <div class="container mt-1 mb-4" style="padding-left:0">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient-primary text-white py-3">
                <h5 class="mb-0 font-weight-bold d-flex align-items-center">
                    <i class="fa-solid fa-list-check me-2"></i> Data Siswa Terdaftar
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary font-weight-bold">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>No. Induk (NIM)</th>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>No. HP</th>
                                <th>Program Studi</th>
                                <th>NFC UID Status</th>
                                <th class="pe-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($students) > 0)
                                @foreach ($students as $student)
                                    <tr>
                                        <td class="ps-4 font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                        <td>
                                            <span class="badge bg-dark px-2.5 py-1.5 font-weight-semibold">
                                                {{ $student->no_induk ?? 'N/A' }}
                                            </span>
                                        </td>
                                        <td class="font-weight-bold text-dark">
                                            {{ $student->userCampus->userSystem->name ?? '-' }}
                                        </td>
                                        <td class="text-muted">
                                            {{ $student->userCampus->userSystem->email ?? '-' }}
                                        </td>
                                        <td>
                                            {{ $student->userCampus->no_hp ?? '-' }}
                                        </td>
                                        <td>
                                            <span class="text-primary font-weight-medium">
                                                {{ $student->program }}
                                            </span>
                                        </td>
                                        <td>
                                            @if($student->userCampus && $student->userCampus->nfc_uid)
                                                <span class="badge bg-success text-white px-2 py-1.5 rounded d-inline-flex align-items-center">
                                                    <i class="fa-solid fa-id-card me-1"></i> {{ $student->userCampus->nfc_uid }}
                                                </span>
                                            @else
                                                <span class="badge bg-light text-secondary border px-2 py-1.5 rounded d-inline-flex align-items-center">
                                                    <i class="fa-solid fa-circle-notch fa-spin me-1 text-warning"></i> Belum Terikat
                                                </span>
                                            @endif
                                        </td>
                                        <td class="pe-4 text-center">
                                            <button class="btn btn-sm btn-outline-secondary btn-detail-dummy" data-name="{{ $student->userCampus->userSystem->name ?? '-' }}">
                                                <i class="fa-solid fa-eye me-1"></i> Detail
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="8" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-inbox fa-3x mb-3 text-secondary d-block mx-auto"></i>
                                        Belum ada data siswa terdaftar.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('create-enrollments') }}" class="btn btn-gradient-primary btn-icon-text font-weight-medium shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Enrollments
        </a>
    </div>

@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

@push('script')
    <script>
        $(document).ready(function () {


            // Button Detail Dummy
            $('.btn-detail-dummy').on('click', function() {
                const name = $(this).data('name');
                Swal.fire({
                    title: 'Detail Siswa',
                    text: `Menampilkan profil detail untuk ${name}. Fitur detail lengkap akan segera hadir!`,
                    icon: 'question',
                    confirmButtonText: 'Tutup',
                    confirmButtonColor: '#343a40'
                });
            });
        });
    </script>
@endpush

@push('page_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .table th {
            border-top: none !important;
            font-size: 0.85rem;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .table td {
            font-size: 0.9rem;
            padding: 15px 10px !important;
        }
        .table-hover tbody tr:hover {
            background-color: rgba(182, 109, 255, 0.04) !important;
            transition: background-color 0.2s ease-in-out;
        }
        .btn-gradient-primary {
            background: linear-gradient(to right, #da8cff, #9a55ff);
            border: 0;
            color: #fff;
            transition: opacity 0.3s ease;
        }
        .btn-gradient-primary:hover {
            opacity: 0.9;
            color: #fff;
        }
        .card-header.bg-gradient-primary {
            background: linear-gradient(to right, #da8cff, #9a55ff) !important;
        }
    </style>
@endpush