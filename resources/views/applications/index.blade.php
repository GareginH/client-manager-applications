@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header font-weight-bold">Заявки @if($dayPassed)<a href="{{route('application.create')}}" class="btn btn-primary float-right">Добавить Заявку</a>@endif</div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Тема</th>
                            <th scope="col">Сообщение</th>
                            <th scope="col">Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applications as $item)
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                <td>{{ $item->subject }}</td>
                                <td>{{ $item->content }}</td>
                                <td style="color:{{$item->active? "green" : "red"}}; font-weight: bold">{{$item->active?"Открытый":"Закрытый" }}</td>
                                <td><a href="{{ route('application.show', $item->id) }}" class="btn btn-outline-success">Посмотреть</a></td>
                                <td>
                                    <form method="POST" action="{{ route('application.close', $item->id) }}" class="mr-1">
                                        @csrf
                                        @method('PATCH')
                                        <button class="btn btn-outline-danger">Закрыть</button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
