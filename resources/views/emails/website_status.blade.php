<x-mail::message>
@component('mail::message')
# Website Check Report

**URL:** {{ $website->url }}  
**Status:** {{ strtoupper($check->status) }}  
**Checked At:** {{ $check->checked_at }}  
**HTTP Code:** {{ $check->http_code ?? 'N/A' }}  
**Response Time:** {{ $check->response_ms ? $check->response_ms . ' ms' : 'N/A' }}

@if($check->error)
**Error:** {{ $check->error }}
@endif

Thanks,  
{{ config('app.name') }}
@endcomponent

</x-mail::message>
