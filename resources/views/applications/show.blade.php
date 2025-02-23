@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Заявка</div>
                    <div class="card-body">
                        <div class="mb-3">
                            <h2>{{$application->subject}}</h2>
                        </div>
                        <div class=" mb-3">
                            <p>{{$application->content}}</p>
                        </div>
                        <div class=" mb-3">
                            <a href="http://agilo/storage/{{$application->file_url}}">Скачать файл</a>
                        </div>
                    </div>
                </div>
                @foreach($messages as $message)
                    <div class="card mb-3 mt-3">
                        <div class="card-body">
                            <div class="mb-3">
                                <h2>{{$message->subject}}</h2>
                            </div>
                            <div class=" mb-3">
                                <p>{{$message->content}}</p>
                            </div>
                            @if($message->file_url != null)
                            <div class=" mb-3">
                                <a href="http://agilo/storage/{{$message->file_url}}">Скачать файл</a>
                            </div>
                            @endif
                            <div class="mb-3 float-right">
                                {{$message->user->name}}
                                {{$message->created_at}}
                            </div>
                        </div>
                    </div>
                @endforeach
                @if($application->active)
                    <div class="card mt-3">
                        <div class="card-header text-uppercase">сообщение</div>

                        <div class="card-body">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            <form method="POST" action="{{ route('message.store', $application->id) }}" enctype="multipart/form-data">
                                @csrf
                                <label for="content">Сообщение</label>
                                <div class="input-group mb-3">
                                    <textarea name="content" id="content" class="form-control"></textarea>
                                </div>
                                <label for="file">Файл</label>
                                <div class="input-group mb-3">
                                    <input type="file" name="file" id="file" class="form-control">
                                </div>
                                <div class="mt-4 float-right">
                                    <input type="submit" value="Отправить" class="btn btn-primary">
                                </div>
                            </form>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
