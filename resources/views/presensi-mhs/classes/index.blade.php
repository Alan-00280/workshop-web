@extends('layouts.app')

@section('db-page-title', 'Daftar Kelas')
@section('icon-page')
    <i class="fa-solid fa-school"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Daftar Kelas</x-ui.breadcrumb-item>
@endsection

@section('content')
    <!-- Button Group / Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('create-class') }}" class="btn btn-gradient-primary btn-icon-text font-weight-bold shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Tambah Kelas
        </a>
    </div>

    <div class="container mt-1 mb-4" style="padding-left:0">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-gradient-primary text-white py-3">
                <h5 class="mb-0 font-weight-bold d-flex align-items-center">
                    <i class="fa-solid fa-list me-2"></i> Daftar Kelas Presensi
                </h5>
            </div>

            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="table-light text-secondary font-weight-bold">
                            <tr>
                                <th class="ps-4">No</th>
                                <th>Nama Kelas</th>
                                <th>Mata Kuliah</th>
                                <th>Mulai</th>
                                <th>Selesai</th>
                                <th class="pe-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if (count($classes) > 0)
                                @foreach ($classes as $class)
                                    <tr>
                                        <td class="ps-4 font-weight-bold text-muted">{{ $loop->iteration }}</td>
                                        <td class="font-weight-bold text-dark">{{ $class->name }}</td>
                                        <td>
                                            <span class="badge bg-light text-primary border border-primary px-2.5 py-1.5 font-weight-semibold">
                                                {{ $class->course->name ?? 'N/A' }}
                                            </span>
                                            <small class="text-muted d-block mt-1">
                                                Code: {{ $class->course->course_code ?? '-' }}
                                            </small>
                                        </td>
                                        <td class="text-secondary">
                                            <i class="fa-regular fa-calendar me-1 text-primary"></i>
                                            {{ $class->schedule_start ? $class->schedule_start->format('d M Y, H:i') : '-' }} WIB
                                        </td>
                                        <td class="text-secondary">
                                            <i class="fa-regular fa-calendar me-1 text-primary"></i>
                                            {{ $class->schedule_end ? $class->schedule_end->format('d M Y, H:i') : '-' }} WIB
                                        </td>
                                        <td class="pe-4 text-center">
                                            <div class="d-flex justify-content-center gap-2">
                                                <!-- Edit Button -->
                                                <a href="{{ route('edit-class', $class->id) }}" class="btn btn-sm btn-outline-warning">
                                                    <i class="fa-solid fa-pen-to-square me-1"></i> Edit
                                                </a>

                                                <!-- Delete Button -->
                                                <form action="{{ route('delete-class', $class->id) }}" method="POST" class="d-inline delete-form">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-outline-danger">
                                                        <i class="fa-solid fa-trash me-1"></i> Hapus
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center py-5 text-muted">
                                        <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary d-block"></i>
                                        Belum ada kelas yang terdaftar.
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            // Confirm delete dialog
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = this;
                Swal.fire({
                    title: 'Hapus Kelas?',
                    text: "Apakah Anda yakin ingin menghapus kelas ini beserta semua relasi data didalamnya?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#fe7c96',
                    cancelButtonColor: '#343a40',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush

@push('page_style')
    <style>
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