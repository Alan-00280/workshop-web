@extends('layouts.app')

@section('db-page-title', 'Sesi Pertemuan Kelas')
@section('icon-page')
    <i class="fa-solid fa-chalkboard-user"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>Sesi Kelas</x-ui.breadcrumb-item>
@endsection

@section('content')
    <!-- Button Group / Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <a href="{{ route('create-class-sessions') }}" class="btn btn-gradient-primary btn-icon-text font-weight-bold shadow-sm">
            <i class="fa-solid fa-plus me-2"></i> Tambah Sesi Kelas
        </a>
    </div>

    <div class="container mt-1 mb-4" style="padding-left:0">
        <div class="row">
            @if (count($sessions) > 0)
                @foreach ($sessions as $session)
                    <div class="col-md-4 mb-4">
                        <div class="card h-100 border-0 shadow-sm session-card cursor-pointer" data-id="{{ $session->id }}">
                            <div class="card-body p-4 d-flex flex-column justify-content-between">
                                <div>
                                    <!-- Class / Course Header -->
                                    <div class="d-flex justify-content-between align-items-start mb-3">
                                        <div>
                                            <span class="badge bg-light text-primary border border-primary px-2.5 py-1 mb-2 font-weight-bold">
                                                {{ $session->class->name ?? 'Kelas N/A' }}
                                            </span>
                                            <h5 class="card-title font-weight-bold text-dark mb-1">
                                                {{ $session->class->course->name ?? 'Mata Kuliah N/A' }}
                                            </h5>
                                            <small class="text-muted d-block">
                                                <i class="fa-solid fa-code me-1 text-secondary"></i> {{ $session->class->course->course_code ?? '-' }}
                                            </small>
                                        </div>
                                    </div>

                                    <!-- Materi / Topic -->
                                    <p class="card-text text-secondary mb-4 mt-2 font-weight-medium">
                                        <strong class="text-dark d-block mb-1"><i class="fa-solid fa-book-open text-primary me-1"></i> Materi Sesi:</strong>
                                        {{ Str::limit($session->materi, 120, '...') }}
                                    </p>
                                </div>

                                <!-- Session Footer Details -->
                                <div class="border-top pt-3 mt-auto">
                                    <div class="row align-items-center">
                                        <!-- Time -->
                                        <div class="col-7">
                                            <small class="text-dark font-weight-semibold d-block">
                                                <i class="fa-regular fa-calendar-days text-primary me-1"></i>
                                                {{ $session->timestamp ? $session->timestamp->format('d M Y') : '-' }}
                                            </small>
                                            <small class="text-muted">
                                                <i class="fa-regular fa-clock me-1"></i>
                                                {{ $session->timestamp ? $session->timestamp->format('H:i') : '-' }} WIB
                                            </small>
                                        </div>

                                        <!-- Attendance Statistics -->
                                        <div class="col-5 text-end">
                                            <span class="badge bg-gradient-primary text-white font-weight-semibold px-2 py-1.5 rounded">
                                                <i class="fa-solid fa-users me-1"></i>
                                                {{ $session->attendances->where('status', 'PRESENT')->count() }} / {{ $session->attendances->count() }} Hadir
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            @else
                <div class="col-12 text-center py-5 text-muted">
                    <div class="card shadow-sm border-0 py-5">
                        <div class="card-body">
                            <i class="fa-solid fa-folder-open fa-3x mb-3 text-secondary d-block"></i>
                            <h5 class="text-dark font-weight-bold mb-2">Belum Ada Sesi Pertemuan Kelas</h5>
                            <p class="text-muted mb-0">Klik tombol di atas untuk mendaftarkan sesi pertemuan kelas yang baru.</p>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('.session-card').on('click', function() {
                const id = $(this).data('id');
                window.location.href = `/teacher-dashboard/class-sessions/${id}/attendance`;
            });
        });
    </script>
@endpush

@push('page_style')
    <style>
        .session-card {
            transition: all 0.3s ease-in-out;
            border-radius: 12px;
        }
        .session-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(182, 109, 255, 0.15) !important;
        }
        .cursor-pointer {
            cursor: pointer;
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
    </style>
@endpush