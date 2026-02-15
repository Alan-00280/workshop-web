@props([
    'errors' => null,
    'type' => 'form'
])

@if ($type == 'form')
    @if ($errors->any())
        <div class="position-fixed start-50 translate-middle-x mt-3 z-3" id="pop-message-err" style="top: 80px">
            <div class="alert alert-danger shadow">
                @foreach ($errors->all() as $message)
                    <strong>{{ $message }}</strong> <br>
                @endforeach
            </div>
        </div>
    @endif
@else
    <div class="position-fixed start-50 translate-middle-x mt-3 z-3" id="pop-message-err" style="top: 80px">
        <div class="alert alert-danger shadow">
            <strong>{{ $errors }}</strong> <br>
        </div>
    </div>
@endif

<script>
    setTimeout(() => {
        const el_err = document.getElementById('pop-message-err');
        if (el_err) {
            el_err.style.transition = 'opacity 0.5s';
            el_err.style.opacity = 0;
            setTimeout(() => el_err.remove(), 500);
        }
    }, 3000);
</script>