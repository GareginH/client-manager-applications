@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">Новая заявка</div>

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
                        <form method="POST" action="{{ route('application.store') }}" enctype="multipart/form-data">
                            @csrf
                        <label for="subject">Тема</label>
                        <div class="input-group mb-3">
                            <input type="text" name="subject" id="subject" class="form-control">
                        </div>
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
            </div>
        </div>
    </div>
@endsection
