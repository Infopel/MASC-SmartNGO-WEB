@component('mail::message')
{{-- <img src="{{ $pathToImage ?? 'https://laravel.com/img/logotype.min.svg'}}"> --}}
{{-- <img src="{{'https://laravel.com/img/logotype.min.svg'}}" width="120"> --}}

<h1>{{ $settings['app_client_short_name'] ?? 'SGMP' }}</h1>
<small>{{ $settings['app_client_name'] ?? 'SGMP' }}</small>
<h2>Alteração de senha!</h2>

**{{$name ?? 'Edilson'}}**,  {{-- - --}}
A senha associada à sua conta no Sistema de Monitoria de Projecto e do Plano Estratégico - {{ $settings['app_client_short_name'] }} foi atualizada com sucesso.  {{-- - --}}
Se você não fez essa solicitação, é muito importante que você desative sua conta e entre em contato imediatamente. <a href="https://support.infopel.com/">https://support.infopel.com/</a>

@component('mail::table')
| Dados da Conta      |          |
| ------------- |:-------------:|
| Nova Senha      | **{{ $password ?? '' }}**      |
@endcomponent

  {{-- - --}}

Melhores Cumprimentos.<br>
{{ $settings['app_title'] }}

@component('mail::subcopy', ['url' => ''])
<p>
    O envio deste e-mail é automático. Por favor, não respondas a esta mensagem, pois o endereço não é monitorado. Se tens alguma questão, comentário ou sugestão, contacta-nos através do endereço: <a href="{{ $url_app ?? '' }}">gespro.co.mz</a>.
</p>
<p>
    <b>Notice to recipient</b>: The information in this email and any attachments may contain confidential and/or privileged information. It is intended solely for the addressee(s). If you are not the intended addressee, please notify the sender immediately (and destroy this email and any attachments from all computers). Any review, copying; redistribution in whole or in parts of this email or its attachments or any other action in reliance to this email or its attachments is strictly prohibited.
</p>
@endcomponent

@endcomponent
