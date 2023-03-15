<div class="text-center mt-2" wire:loading.class.delay="opacity-50">
    @foreach($colorPalette as $color)
        <span class="color-item shadow-hover-5" style="background-color: {{ $color }}"
              wire:click="save('{{ $color }}')"
        ></span>
    @endforeach
</div>
