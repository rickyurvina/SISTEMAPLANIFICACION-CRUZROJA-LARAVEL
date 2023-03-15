@component('mail::layout')
    {{-- Header --}}
    @slot('header')
        @component('mail::header', ['url' => config('app.url')])
            <img src="{{ url('/'). '/img/logo_cre_trans.png' }}" class="width-2" alt="{{ config('app_name') }} Logo">
        @endcomponent
    @endslot

    {{-- Body --}}
    # Hola {{ $name }}

    {{-- Subcopy --}}
    @slot('subcopy')
        @component('mail::subcopy')
            Esta es una plantilla de ejemplo, a partir de la cual se pueden generar nuevas plantillas de acuerdo a las necesidades específicas de cada notificación por correo.
            @component('mail::button', ['url' => $url])
                Click aquí
            @endcomponent
            @component('mail::table')
                | Columna 1     | Columna 2     | Valor Ejemplo  |
                | :-----------: |:--------------| --------------:|
                | Data 1        | Descripción 1 | $10            |
                | Data 2        | Descripción 2 | $20            |
            @endcomponent
            @component('mail::panel')
                {{ $body }}
            @endcomponent
        @endcomponent
        Gracias,<br>
        {{ config('app.name') }}
    @endslot


    {{-- Footer --}}
    @slot('footer')
        @component('mail::footer')
            Cruz Roja Ecuatoriana, todos los derechos reservados.
        @endcomponent
    @endslot
@endcomponent
