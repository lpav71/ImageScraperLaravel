@extends('layouts.app')

@section('content')
    <form action="{{ route('fetch-images') }}" method="post">
        @csrf
        <label for="url" class="form-label">Введите URL:</label>
        <input type="url" id="url" name="url" class="form-control" required>
        <button type="submit" class="btn btn-primary mt-3">Go</button>
    </form>
@endsection

