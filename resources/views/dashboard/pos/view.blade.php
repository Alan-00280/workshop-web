@extends('layouts.app')

@section('db-page-title', 'Point of Sales')
@section('icon-page')
    <i class="fa-solid fa-cart-shopping"></i>
@endsection

@section('breadcrumb')
    <x-ui.breadcrumb-item>point of sales</x-ui.breadcrumb-item>
@endsection

@section('content')
    <div class="container mt-1" style="padding-left:0">

        <div class="card shadow mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0">header card</h5>
            </div>

            <div class="card-body">

            </div>
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

        $(document).ready(function () {

        });

    </script>
@endpush

@push('page_style')
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" integrity="sha512-nMNlpuaDPrqlEls3IX/Q56H36qvBASwb3ipuo3MxeWbsQB1881ox0cRv7UPTgBlriqoynt35KjEwgGUeUXIPnw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@endpush