@component('mail::message', ['pathToImage' => $pathToImage])
{{-- <img src="{{ $pathToImage }}"> --}}

<h1>{{ $settings['app_client_short_name'] ?? 'SGMP' }}</h1>
<small>{{ $settings['app_client_name'] ?? 'Sistema de Monitoria de Projecto e do Plano Estratégico' }}</small>
<h2>Nova Conta: Bem-vindo ao SGMP - MASC</h2>

Olá **{{$name}}**,  {{-- - --}}
Foi criada uma conta para si no Sistema de Monitoria de Projecto e do Plano Estratégico do MASC.  {{-- - --}}
Para aceder ao sistema deve clicar no link: <a href="http://3.130.36.108/">http://3.130.36.108/</a> e utilizar as credenciais
{{-- Para concluir o processo de registro e ativar sua conta, clique no link abaixo --}}

@component('mail::table')
| Dados da Conta      |          |
| ------------- |:-------------:|
| Nome do usuário      | **{{ $login ?? '' }}**      |
| Senha      | **{{ $password ?? '' }}**      |
@endcomponent

  {{-- - --}}

{{-- @component('mail::button', ['url' => $url])
Ativar conta
@endcomponent --}}

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
