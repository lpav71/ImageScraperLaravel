@extends('layouts.app')

@section('content')
    <a href="{{ route('index') }}">Назад</a>
    <div class="d-flex flex-wrap">
        @foreach ($images as $image)
            <div class="d-flex flex-column" style="padding: 10px">
                <img src="{{ $image['src'] }}" alt="Image" width="400">
                <span>Размер: {{ $image['size_mb'] }} Mb</span>
            </div>
        @endforeach
    </div>
    <p>На странице обнаружено {{ count($images) }} изображений, общим размером {{ $totalSize }} Мб</p>
@endsection
