@component('mail::message')
# Your hostname changes have been submitted.

Please click the update changes button to accept the following changes:

Name:        **{{ $hostname->fullName() }}**<br>
IP Address:    **{{ $changes['ip'] }}**<br>
Expires:       **{{ \Carbon\Carbon::parse($changes['expires_at'])->toDayDateTimeString() }}**<br>

@component('mail::button', ['url' => $url])
Update Changes
@endcomponent

This update changes link will expire in one day.

Thanks,<br>
{{ config('app.name') }}
@endcomponent
