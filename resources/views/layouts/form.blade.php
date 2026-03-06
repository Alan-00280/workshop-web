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

@push('script')
    <script>
        $(document).ready(function () {
            const form = $("div.content-wrapper form")
            $("button[type='submit']").click(function (e) {
                let isValid = true
                e.preventDefault()

                const inputs = form.find("input")
                const selects = form.find("select")

                inputs.each(function () {
                    if (this.validity.valueMissing) {
                        isValid = false
                        this.classList.add('is-invalid')
                        const requiredErrSPAN = $('<span>', {
                            class: "error",
                            text: "Required"
                        })

                        if ($(this).parent().hasClass("input-group")) {
                            $(this).parent().addClass("outline-red")
                            if ($(this).parent().next(".error").length === 0) {
                                $(this).parent().after(requiredErrSPAN)
                            }
                        } else {
                            if (!$(this).next().hasClass("error")) {
                                $(this).after(requiredErrSPAN)
                            }
                        }
                    }
                })

                selects.each(function () {
                    if (this.validity.valueMissing) {
                        isValid = false
                        this.classList.remove('form-select')
                        this.classList.add('is-invalid')
                        this.classList.add('form-select-invalid')

                        if (!$(this).next().hasClass("error")) {
                            const requiredErrSPAN = $('<span>', {
                                class: "error",
                                text: "Required"
                            })
                            $(this).after(requiredErrSPAN)
                        }
                    }
                })

                if (isValid) {
                    $("div.content-wrapper form input, div.content-wrapper form select").prop('readonly', true)
                    $("div.content-wrapper form button[type='submit'], div.content-wrapper form button[type='reset']").prop('disabled', true)

                    $(this).removeClass('btn-success')
                    $(this).addClass('btn-secondary')
                    $(this).html(`
                        <span class="spinner-border spinner-border-sm me-2"></span>
                        Loading...
                    `)

                    form.submit()
                }
            })
        })
    </script>
@endpush

@push('script')
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush

@push('script')
    <script>
        // Bintang Bintang 
        const resetInputStar = () => {
            const labels = document.querySelectorAll('label');
            labels.forEach((label) => {
                const star = label.querySelector('span.text-danger');
                if (star) {
                    star.remove();
                }
            })
        }

        const inputGroups = document.querySelectorAll("div.content-wrapper form .input-group")
        const inputs = document.querySelectorAll('div.content-wrapper form input');
        const selects = document.querySelectorAll('div.content-wrapper form select');
        const resetBtn = document.querySelector('button[type="reset"]')
        resetBtn.addEventListener('click', (e) => {
            resetInputStar()
            inputs.forEach((input) => {
                input.classList.remove('is-invalid')
            })
            selects.forEach((select) => {
                select.classList.remove('is-invalid')
                select.classList.remove('form-select-invalid')
                select.classList.add('form-select')
            })
            inputGroups.forEach((inputGroup) => {
                inputGroup.classList.remove('outline-red')
            })
            document.querySelectorAll('.error').forEach((e) => e.remove())
        })

        inputs.forEach((input) => {
            input.addEventListener('input', function () {
                let label = document.querySelector('label[for="' + input.id + '"]');

                if (label && !label.querySelector('span')) {
                    label.innerHTML += ' <span class="text-danger">*</span>';
                }
            });
        });

        selects.forEach((input) => {
            input.addEventListener('input', function () {
                let label = document.querySelector('label[for="' + input.id + '"]');

                if (label && !label.querySelector('span')) {
                    label.innerHTML += ' <span class="text-danger">*</span>';
                }
            });
        });

    </script>
@endpush

@push('page_style')
    <style>
        .error {
            color: red;
        }

        .outline-red {
            outline: red 1px solid
        }

        .form-select-invalid {
            padding: 0.4375rem 0.75rem;
            border: 0;
            outline: 1px solid #ff0000;
            color: #ff3b3b;
            display: block;
            width: 100%;
            font-size: 1rem;
            font-weight: 400;
            line-height: 1.5;
            background-image: var(--bs-form-select-bg-img), var(--bs-form-select-bg-icon, none);
            background-repeat: no-repeat;
            background-position: right 0.75rem center;
            background-size: 16px 12px;
            border-radius: var(--bs-border-radius);
            --bs-form-select-bg-img: url(data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%23343a40' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='m2 5 6 6 6-6'/%3e%3c/svg%3e);
        }
    </style>
@endpush