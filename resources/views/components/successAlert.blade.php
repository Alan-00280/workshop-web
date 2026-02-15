@props([
    'message' => null
])

@if ($message)
    <div class="position-fixed start-50 translate-middle-x mt-3 z-3" id="pop-message" style="top: 80px">
        <div class="alert alert-success shadow">
            <strong>{{ $message }}</strong>
        </div>
    </div>
@endif

<script>
    setTimeout(() => {
        const el = document.getElementById('pop-message');
        if (el) {
            el.style.transition = 'opacity 0.5s';
            el.style.opacity = 0;
            setTimeout(() => el.remove(), 500);
        }
    }, 1500);
</script>