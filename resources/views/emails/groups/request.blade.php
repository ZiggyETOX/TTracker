@component('mail::message')
# You have been invited by {{ $groupinfo["groupinfo"]["from"] }} to join his group on TTracker

You have been invited to join a group called {{ $groupinfo["groupinfo"]["name"] }}<br>
By: {{ $groupinfo["groupinfo"]["from"] }}

Description:
{{ $groupinfo["groupinfo"]["description"] }}

@component('mail::button', ['url' => $groupinfo["groupinfo"]["url"] . '/add/' . $groupinfo["groupinfo"]["pin"], 'color' => 'success'])
Join group
@endcomponent

Thanks,<br>
{{ config('app.name') }}
@endcomponent
