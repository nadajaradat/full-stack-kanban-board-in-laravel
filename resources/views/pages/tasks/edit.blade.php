@extends('layout.app')

@section('title', 'Update task ' . $task->title)

@section('content')
    <div class="container-fluid">
        <form method="post" action="{{ route('tasks.update', [$task]) }}">
            @method('PUT')
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value="{{ old('title') ?? $task->title }}" placeholder="Your title">
            </div>
            @error('title')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
            @enderror
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') ?? $task->description }}</textarea>
            </div>
            <input type="hidden" name ="status" value="{{ old('status') ?? $task->status }}">

            @error('description')
            <div class="alert alert-danger" role="alert">
                {{ $message }}
            </div>
            @enderror
            <div class="mb-3">
                <button type="submit" class="btn btn-dark">Update</button>
            </div>
        </form>
    </div>
@endsection
