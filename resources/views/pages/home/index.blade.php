@extends('layout.app')

@section('title', '|home')

    @section('content')
    Hi @auth
    {{Auth::user()->name}}

    @else User
    @endauth


    

@auth
    <header class="mt-2">This is your latest tasks</header>
    @foreach(auth()->user()->tasks as $task)
        <div class="component m-5">
            @include('components.task-card', ['task'=> $task, 'status' => $task->status])
        </div>
        
    @endforeach
@endauth


@endsection