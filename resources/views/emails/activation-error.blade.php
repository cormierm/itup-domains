@component('mail::message')
# Error activating your hostname.

We encountered an error trying to activate {{ $domain }}. Please try again with another hostname or if you think you received this is error please contact support.

Sincerely,<br>
{{ config('app.name') }}
@endcomponent
