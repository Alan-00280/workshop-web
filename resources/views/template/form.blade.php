@extends('layouts.form') {{--? FORM LAYOUT ?--}}

@section('db-page-title', 'PAGE TITLE')
@section('icon-page')
    <i class="fa-solid fa-map-location-dot"></i> {{--TODO CHANGE ICON --}}
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>BREADCRUMB</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-3">
        <a href="{{--TODO LINK TO PREVIOUS PAGE  --}}" class="btn btn-primary">
            <i class="fa-solid fa-arrow-left"></i>
            Kembali
        </a>
    </div>

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">FORM TITLE</h5>
        </div>

        <div class="card-body">
            <form action="{{-- FORM_ROUTE --}}" method="HTTP.METHOD">
                @csrf

                <!-- Field_1 -->
                <div class="mb-3">
                    <label for="field" class="form-label">Field_Label</label>
                    <input type="text" 
                           name="field" 
                           id="field"
                           value="{{ old('field') }}"
                           class="form-control @error('field') is-invalid @enderror"
                           placeholder="Masukkan <field>"
                           required>

                    @error('field')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                    @enderror
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

        });

    </script>
@endpush

{{-- Page Style --}}
@push('page_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush