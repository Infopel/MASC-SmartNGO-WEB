@component('mail::message')
<h1>{{ $settings['app_client_short_name'] ?? 'SGMP' }}</h1>
<small>{{ $settings['app_client_name'] ?? 'SGMP' }}</small>
<h4>Nova Tarefa Criada</h4>

<p>
    Caro (nome do usuário)
    {{-- - --}}
Foi criada uma tarefa: (<a href="#">nome da tarefa</a>) no projecto (<a href="#">nome do projecto</a>) a decorrer (Data)
pelo <i>Assistente de Projectos - Edilson Mucanze</i>. Para aprovação da tarefa, <a href="#">clique aqui</a>.
</p>
  {{-- - --}}

<h5 style="margin:0px">Melhores Cumprimentos.</h5>
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
