@component('mail::message')
# Congrats your hostname has been registered.

Please click the activate button to activate the following hostname:

Name:        **{{ $hostname->fullName() }}**<br>
IP Address:    {{ $hostname->ip }}<br>
Expires:       {{ $hostname->expires_at->toDayDateTimeString() }}<br>

@component('mail::button', ['url' => $url])
Activate Hostname
@endcomponent

This activation link will expire in one day.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
