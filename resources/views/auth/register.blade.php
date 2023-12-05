@extends('layout.app')

@section('title', 'register')

@section('content')
    <div class="container-fluid">
        <form method="post" action="{{ route('register') }}">
            @csrf
            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value = "{{old('name')}}" placeholder="Your name">
            </div>
            @error('name')
            <div class="alert alert-danger" role="alert">
            {{$message}}
            </div>
            @enderror
            <div class="mb-3">
                <label for="email" class="form-label">email</label>
                <input type="email" class="form-control" id="email" name="email" value = "{{old('email')}}" placeholder="Your email">
            </div>
            @error('email')
            <div class="alert alert-danger" role="alert">
            {{$message}}
            </div>
            @enderror
            <div class="mb-3">
                <label for="password" class="form-label">password</label>
                <input type="password" class="form-control" id="password" name="password" value = "{{old('password')}}" placeholder="Your password">
            </div>
            @error('password')
            <div class="alert alert-danger" role="alert">
            {{$message}}
            </div>
            @enderror
            <div class="mb-3">
                <button type="submit" class="btn btn-dark">Submit</button>
            </div>
        </form>
        if you already have an account <a href='{{route("login")}}'>login</a>
    </div>
@endsection
