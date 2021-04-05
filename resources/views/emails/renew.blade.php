@component('mail::message')
# Your hostname is expired.

The following hostname is expired and needs to be renewed:

Name:        **{{ $hostname->fullName() }}**<br>
IP Address:    **{{ $changes['ip'] }}**<br>
Expired:       **{{ \Carbon\Carbon::parse($changes['expires_at'])->toDayDateTimeString() }}**<br>

@component('mail::button', ['url' => $url])
Renew Hostname
@endcomponent

This renew hostname link will expire in one week. If you no longer want this hostname, no action is required and it will automatically be deleted in one week.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
