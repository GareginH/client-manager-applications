@component('mail::message')
# Новая заявка от {{$applicant}}

# {{$subject}}

### {{$content}}

[Прикрепленный файл]({{$file}})

@component('mail::button', ['url' => ''])
Перейти
@endcomponent

<br>
{{ config('app.name') }}
@endcomponent
