<div class="d-flex justify-content-between align-items-center">
    <div class="d-flex justify-content-start align-items-center">
        <h2 style="font-size: 1rem; font-weight: 600; line-height: 24px;" class="m-0">
            {{ $slot }}
        </h2>
    </div>
    @if(isset($actions))
        {{ $actions }}
    @endif
</div>
