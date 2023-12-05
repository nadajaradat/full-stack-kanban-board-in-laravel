@extends('layout.app')

@section('title', 'create')

@section('content')
    <div class="container-fluid">
        <form method="post" action="{{ route('tasks.store') }}">
            @csrf
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" value = "{{old('title')}}" placeholder="Your title">
            </div>
            @error('title')
            <div class="alert alert-danger" role="alert">
            {{$message}}
            </div>
            @enderror
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" value = "{{old('description')}}" rows="3"></textarea>
            </div>
            
            <input type="hidden" name ="status" value="{{$status}}">
            @error('description')
            <div class="alert alert-danger" role="alert">
            {{$message}}
            </div>
            @enderror
            <div class="mb-3">
                <button type="submit" class="btn btn-dark">Submit</button>
            </div>
        </form>
    </div>
@endsection
