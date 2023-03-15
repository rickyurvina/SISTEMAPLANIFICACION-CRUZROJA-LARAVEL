<tr>
<td class="header">
<a href="{{ $url }}" style="display: inline-block;">
@if (trim($slot) === 'Laravel')
        <img src="{{ url('/'). '/img/logo_cre_trans.png' }}" class="width-2" alt="{{ config('app_name') }} Logo">
    @else
{{ $slot }}
@endif
</a>
</td>
</tr>
