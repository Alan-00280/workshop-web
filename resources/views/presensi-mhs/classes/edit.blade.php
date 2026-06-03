@extends('layouts.app')

@section('db-page-title', 'Edit Kelas')
@section('icon-page')
    <i class="fa-solid fa-school"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item href="{{ route('show-classes') }}">Daftar Kelas</x-ui.breadcrumb-item>
    <x-ui.breadcrumb-item>Edit</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{ route('show-classes') }}" class="btn btn-outline-secondary">
            <i class="fa-solid fa-arrow-left me-1"></i> Kembali
        </a>
    </div>

    <div class="card shadow-sm border-0">
        <div class="card-header bg-gradient-primary text-white py-3">
            <h5 class="mb-0 font-weight-bold d-flex align-items-center">
                <i class="fa-solid fa-pen-to-square me-2"></i> Edit Data Kelas
            </h5>
        </div>

        <div class="card-body p-4">
            <form action="{{ route('update-class', $class->id) }}" method="POST">
                @csrf
                @method('PATCH')

                <!-- Nama Kelas -->
                <div class="form-group mb-3">
                    <label for="name" class="font-weight-bold text-dark">Nama Kelas</label>
                    <input type="text" class="form-control @error('name') is-invalid @enderror" id="name" name="name" value="{{ old('name', $class->name) }}" placeholder="Contoh: Kelas IF301 - Paralel A" required>
                    @error('name')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Pilih Mata Kuliah -->
                <div class="form-group mb-3">
                    <label for="course_id" class="font-weight-bold text-dark">Pilih Mata Kuliah</label>
                    <select name="course_id" id="course_id" class="form-control select2 @error('course_id') is-invalid @enderror" required>
                        <option value="" disabled>Pilih Mata Kuliah...</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}" {{ old('course_id', $class->course_id) == $course->id ? 'selected' : '' }}>
                                {{ $course->name }} ({{ $course->course_code }})
                            </option>
                        @endforeach
                    </select>
                    @error('course_id')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <!-- Waktu Mulai & Waktu Selesai -->
                <div class="row">
                    <div class="col-md-6 form-group mb-3">
                        <label for="schedule_start" class="font-weight-bold text-dark">Waktu Mulai Kelas</label>
                        <input type="datetime-local" class="form-control @error('schedule_start') is-invalid @enderror" id="schedule_start" name="schedule_start" value="{{ old('schedule_start', $class->schedule_start ? $class->schedule_start->format('Y-m-d\TH:i') : '') }}" required>
                        @error('schedule_start')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="col-md-6 form-group mb-4">
                        <label for="schedule_end" class="font-weight-bold text-dark">Waktu Selesai Kelas</label>
                        <input type="datetime-local" class="form-control @error('schedule_end') is-invalid @enderror" id="schedule_end" name="schedule_end" value="{{ old('schedule_end', $class->schedule_end ? $class->schedule_end->format('Y-m-d\TH:i') : '') }}" required>
                        @error('schedule_end')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Submit Button -->
                <div class="d-flex justify-content-between align-items-center pt-3 border-top">
                    <a href="{{ route('show-classes') }}" class="btn btn-light border">
                        Batal
                    </a>
                    <button type="submit" class="btn btn-gradient-primary btn-icon-text font-weight-bold shadow-sm">
                        <i class="fa-solid fa-save me-1"></i> Perbarui Kelas
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js" integrity="sha512-RtZU3AyMVArmHLiW0suEZ9McadTdegwbgtiQl5Qqo9kunkVg1ofwueXD8/8wv3Af8jkME3DDe3yLfR8HSJfT2g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
@endpush

@push('script')
    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Pilih Mata Kuliah",
                allowClear: true,
                width: '100%'
            });
        });
    </script>
@endpush

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
        .form-control:focus {
            border-color: #da8cff;
            box-shadow: 0 0 0 0.2rem rgba(218, 140, 255, 0.25);
        }
    </style>
@endpush
