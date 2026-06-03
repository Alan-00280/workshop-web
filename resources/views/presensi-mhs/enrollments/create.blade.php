@extends('layouts.app') {{-- Merubah ke layouts.app agar konsisten dengan sidebar dan header standard --}}

@section('db-page-title', 'Tambah Enrollments')
@section('icon-page')
    <i class="fa-solid fa-user-check"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item href="{{ route('show-students') }}">Student</x-ui.breadcrumb-item>
    <x-ui.breadcrumb-item>Create Enrollments</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('show-students') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i>
            Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <h5 class="mb-0 font-weight-bold d-flex align-items-center">
                <i class="fa-solid fa-plus me-2"></i> Daftarkan Siswa ke Kelas
            </h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('store-enrollments') }}" method="POST">
                @csrf

                <!-- Pilih Kelas -->
                <div class="mb-3">
                    <label for="class_id" class="form-label font-weight-bold text-dark">Pilih Kelas</label>
                    <select name="class_id" id="class_id" class="form-control select2 @error('class_id') is-invalid @enderror" required>
                        <option value="" disabled selected>Pilih Kelas...</option>
                        @foreach($classes as $class)
                            <option value="{{ $class->id }}" {{ old('class_id') == $class->id ? 'selected' : '' }}>
                                {{ $class->name }} ({{ $class->course->name ?? '-' }})
                            </option>
                        @endforeach
                    </select>

                    @error('class_id')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Pilih Siswa (Multiple) -->
                <div class="mb-4">
                    <label for="student_ids" class="form-label font-weight-bold text-dark">Pilih Siswa</label>
                    <select name="student_ids[]" id="student_ids" class="form-control select2-multiple @error('student_ids') is-invalid @enderror" multiple="multiple" required>
                        @foreach($students as $student)
                            <option value="{{ $student->id }}" {{ is_array(old('student_ids')) && in_array($student->id, old('student_ids')) ? 'selected' : '' }}>
                                {{ $student->no_induk }} - {{ $student->userCampus->userSystem->name ?? '-' }} ({{ $student->program }})
                            </option>
                        @endforeach
                    </select>

                    @error('student_ids')
                        <div class="invalid-feedback d-block">
                            {{ $message }}
                        </div>
                    @enderror
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('show-students') }}" class="btn btn-light border">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-gradient-primary btn-icon-text font-weight-bold shadow-sm">
                        <i class="fa-solid fa-save me-1"></i> Simpan Enrollments
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

{{-- CDNs --}}
@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

{{-- scripts --}}
@push('script')
    <script>
        $(document).ready(function () {
            $('.select2').select2({
                placeholder: "Pilih Kelas",
                allowClear: true,
                width: '100%'
            });
            $('.select2-multiple').select2({
                placeholder: "Pilih satu atau beberapa siswa...",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush

{{-- Page Style --}}
@push('page_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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