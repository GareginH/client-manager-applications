@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-header">Фильтр</div>
            <div class="card-body">
                <form action="?" method="GET">
                    <div class="row">
                        <div class="col">
                            <div class="form-group">
                                <label for="seen" class="col-form-label">Просмотренные/Непросмотренные</label>
                                <select id="seen" class="form-control" name="seen">
                                    <option value="0" {{ request('seen') ? ' selected' : ''}}>Непросмотренные</option>
                                    <option value="1" {{ request('seen') ? ' selected' : ''}}>Просмотренные</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="active" class="col-form-label">Закрытые/Незакрытые</label>
                                <select id="active" class="form-control" name="active">
                                    <option value="0" {{ request('active') ? ' selected' : ''}}>Закрытые</option>
                                    <option value="1" {{ request('active') ? ' selected' : ''}}>Незакрытые</option>
                                </select>
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="reply" class="col-form-label">Есть ответ менеджера.</label>
                                <select id="reply" class="form-control" name="reply">
                                    <option value="0" {{ request('reply') ? ' selected' : ''}}>Нет</option>
                                    <option value="1" {{ request('reply') ? ' selected' : ''}}>Да</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="col-form-label">&nbsp;</label><br />
                                <button type="submit" class="btn btn-primary">Поиск</button>
                                <a href="?" class="btn btn-outline-secondary">Видеть Все</a>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
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
