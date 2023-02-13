@component('mail::message')
{{-- Greeting --}}
@if (! empty($greeting))
# {{ $greeting }}
@else
@if ($level === 'error')
# @lang('Whoops!')
@else
# @lang('Hello!')
@endif
@endif

{{-- Intro Lines --}}
@foreach ($introLines as $line)
{{ $line }}

@endforeach

{{-- Action Button --}}
@isset($actionText)
<?php
    switch ($level) {
        case 'success':
        case 'error':
            $color = $level;
            break;
        default:
            $color = 'primary';
    }
?>
@component('mail::button', ['url' => $actionUrl, 'color' => $color])
{{ $actionText }}
@endcomponent
@endisset

{{-- Outro Lines --}}
@foreach ($outroLines as $line)
{{ $line }}

@endforeach

{{-- Salutation --}}
@if (! empty($salutation))
{{ $salutation }}
@else
@lang('Regards'),<br>
{{ $settings['app_title'] }}
@endif

{{-- Subcopy --}}
@isset($actionText)
@slot('subcopy')
@lang(
    "If you’re having trouble clicking the \":actionText\" button, copy and paste the URL below\n".
    'into your web browser: [:actionURL](:actionURL)',
    [
        'actionText' => $actionText,
        'actionURL' => $actionUrl,
    ]
)
@endslot
@endisset

@component('mail::subcopy', ['url' => ''])
<p>
    O envio deste e-mail é automático. Por favor, não respondas a esta mensagem, pois o endereço não é monitorado. Se tens alguma questão, comentário ou sugestão, contacta-nos através do endereço: <a href="#">gespro.co.mz</a>.
</p>
<p>
    <b>Notice to recipient</b>: The information in this email and any attachments may contain confidential and/or privileged information. It is intended solely for the addressee(s). If you are not the intended addressee, please notify the sender immediately (and destroy this email and any attachments from all computers). Any review, copying; redistribution in whole or in parts of this email or its attachments or any other action in reliance to this email or its attachments is strictly prohibited.
</p>
@endcomponent

@endcomponent
