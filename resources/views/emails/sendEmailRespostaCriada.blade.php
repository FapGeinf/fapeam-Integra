@component('mail::message')
# Nova Resposta Criada

Há uma nova mensagem do usuário **{{ auth()->user()->name }}**.

@component('mail::button', ['url' => route('riscos.respostas', ['id' => $notificacao->monitoramentoId])])
Ver Resposta
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
