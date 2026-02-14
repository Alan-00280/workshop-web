@extends('layouts.app')

@section('db-page-title')
    @yield('title')
@endsection

@section('icon-page')
    @yield('icon')
@endsection

@section('breadcrumb')
    @yield('breadcrumb-form')
@endsection

@section('content')
    @yield('form-content')
@endsection

@section('script')
<script>
    const resetInputStar = () => {
        const labels = document.querySelectorAll('label');
        labels.forEach((label) => {
            const star = label.querySelector('span.text-danger');
            if (star) {
                star.remove();
            }
        })
    }
    const resetBtn = document.querySelector('button[type="reset"]')
    resetBtn.addEventListener('click', (e) => {
        resetInputStar()
    })

    const inputs = document.querySelectorAll('input');
    inputs.forEach((input) => {
        input.addEventListener('input', function() {
            let label = document.querySelector('label[for="' + input.id + '"]');

            if (label && !label.querySelector('span')) {
                label.innerHTML += ' <span class="text-danger">*</span>';
            }
        });
    });

    const selects = document.querySelectorAll('select');
    selects.forEach((input) => {
        input.addEventListener('input', function() {
            let label = document.querySelector('label[for="' + input.id + '"]');

            if (label && !label.querySelector('span')) {
                label.innerHTML += ' <span class="text-danger">*</span>';
            }
        });
    });

</script>
@endsection
