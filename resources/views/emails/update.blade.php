@component('mail::message')
# Изменения в заявке ({{$subject}}) от {{$applicant}}
@component('mail::button', ['url' => ''])
    Перейти
@endcomponent
<br>
{{ config('app.name') }}
@endcomponent
