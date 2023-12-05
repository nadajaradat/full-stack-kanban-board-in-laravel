@extends('layout.app')

@section('title', 'login')

@section('content')
    <div class="container-fluid">
        <form method="post" action="{{ route('login') }}">
            @csrf
            
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
                <button type="submit" class="btn btn-dark">Login</button>
            </div>
        </form>
        if you don't have an account <a href='{{route("register")}}'>register</a>
    </div>
@endsection
