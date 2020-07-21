@component('mail::message')
# Congrats your sub domain has been registered.

Please click the activate button to activate sub domain.

@component('mail::button', ['url' => $url])
Activate Sub Domain
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
