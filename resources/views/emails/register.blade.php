@component('mail::message')
# Congrats your hostname has been registered.

Please click the activate button to activate hostname.

@component('mail::button', ['url' => $url])
Activate Hostname
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
