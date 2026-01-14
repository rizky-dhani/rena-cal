<x-mail::message>
# {{ __('notifications.calibration_renewal.title') }}

{{ __('notifications.calibration_renewal.greeting', ['name' => $name]) }}

{{ __('notifications.calibration_renewal.body') }}

<x-mail::table>
| {{ __('notifications.calibration_renewal.device_name') }} | {{ __('notifications.calibration_renewal.serial_number') }} | {{ __('notifications.calibration_renewal.next_calibration_date') }} |
| :------------------------------------------------------- | :--------------------------------------------------------- | :----------------------------------------------------------------- |
@foreach ($devices as $device)
| {{ $device->deviceName?->name ?? 'N/A' }} | {{ $device->serial_number ?? 'N/A' }} | {{ $device->next_calibration_date }} |
@endforeach
</x-mail::table>

<x-mail::button :url="config('app.url')">
{{ __('notifications.calibration_renewal.action') }}
</x-mail::button>

{{ __('Regards') }},<br>
{{ config('app.name') }}
</x-mail::message>
