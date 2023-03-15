<div class="my-5 blank-page">
    <div>
        @if(isset($img))
            {{ $img }}
        @else
            <i class="fas fa-info-circle fa-7x mb-4 d-flex justify-content-center align-items-center" style="color: #2582fd"></i>
        @endif

        @if(isset($title))
            <h4 class="d-flex justify-content-center align-items-center">{{ $title }}</h4>
        @endif

        @if(isset($info))
            <p>{{ $info }}</p>
        @endif

        <div class="d-flex justify-content-center align-items-center">
            {{ $slot }}
        </div>
    </div>
</div>
