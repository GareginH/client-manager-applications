@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header font-weight-bold">Заявки</div>

                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">От</th>
                            <th scope="col">Тема</th>
                            <th scope="col">Сообщение</th>
                            <th scope="col">Принят</th>
                            <th scope="col">Статус</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($applications as $item)
                            <tr>
                                <th scope="row">{{$item->id}}</th>
                                <td>{{ $item->user->name }}</td>
                                <td>{{ $item->subject }}</td>
                                <td>{{ $item->content }}</td>
                                <td>{{ $item->manager? $item->manager->name : '-' }}</td>
                                <td style="color:{{$item->active? "green" : "red"}}; font-weight: bold">{{$item->active?"Открытый":"Закрытый" }}</td>
                                <td><a href="{{ route('application.manager.show', $item->id) }}" class="btn btn-outline-success">Посмотреть</a></td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
