<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home() {

        $tasks = Task::orderByDesc('created_at')->take(5)->get();
        return view('pages.home.index',['tasks' => $tasks]);
    }
    public function dashboard() {
        $tasks = Task::all();
        return view('pages.tasks.dashboard', ['tasks'=> $tasks]);
    }
}
