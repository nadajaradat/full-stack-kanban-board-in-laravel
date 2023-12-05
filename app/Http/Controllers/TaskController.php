<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskFormRequest;
use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $status = $request->query('status');
        return view('pages.tasks.create', ['status' => $status]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TaskFormRequest $request)
    {
        $validatedData = $request->validated();

        // Find the maximum position for tasks with the same status
        $maxPosition = Task::where('status', $validatedData['status'])->max('position');

        // Set the new task's position
        $validatedData['position'] = $maxPosition + 1;

        // Create the task
        $task = $request->user()->tasks()->create($validatedData);

        return redirect()
            ->route('dashboard')
            ->with('success', "Task submitted successfully.");
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        return view('pages.tasks.show',[
            'task'=>$task],
            );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        $this -> authorize('update', $task);
        return view('pages.tasks.edit',[
            'task'=>$task],
            );
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(TaskFormRequest $request, Task $task)
    {
        $validated = $request -> validated();
        $this -> authorize('update', $task);

        $task->update($validated);

        return redirect()
            ->route('tasks.show', [$task])
            ->with('success', "task is updated!");
    }

 
    public function updateValue( $id, $status, $position)
    {
        // Find the task in the database
        $task = Task::findOrFail($id);
    
        // Check if another task in the same status already has the same position
        $existingTask = Task::where('status', $status)
            ->where('position', $position)
            ->where('id', '!=', $id) // Exclude the current task from the check
            ->first();
    
        $prevStatus = $task->status;
        $prevPosition = $task->position;
    
        // Delete the task
        $this->authorize('delete', $task);
        $task->delete();

         // Update positions
         Task::where('status', $status)
         ->orderBy('position')
         ->get()
         ->each(function ($task, $index) {
             $task->update(['position' => $index + 1]);
         });
 
        Task::where('status', $prevStatus)
         ->orderBy('position')
         ->get()
         ->each(function ($task, $index) {
             $task->update(['position' => $index + 1]);
         });

         // Find the maximum position for tasks with the same status
        $maxPosition = Task::where('status', $status)->max('position');
    
        // Shift positions based on conditions
        if ($position == 1) {
            Task::where('status', $prevStatus)
            ->where('position', '>=', $position)
            ->where('id', '!=', $id)
            ->increment('position');
        } elseif ($prevPosition == 1) {
            Task::where('status', $prevStatus)
                ->where('position', '>=', $position)
                ->where('id', '!=', $id)
                ->decrement('position');
        } elseif ($position == $maxPosition) {
            $position = $maxPosition+1;
        }elseif ($existingTask) {
            // Shift positions to make room for the updated task
            Task::where('status', $status)
                ->where('position', '>=', $position)
                ->where('id', '!=', $id)
                ->increment('position');
        }

        $task->status = $status;
        $task->position = $position;

        $task->user()->associate(auth()->user());
        $task->save();
    
    
        // Update positions
        Task::where('status', $status)
            ->orderBy('position')
            ->get()
            ->each(function ($task, $index) {
                $task->update(['position' => $index + 1]);
            });
    
        Task::where('status', $prevStatus)
            ->orderBy('position')
            ->get()
            ->each(function ($task, $index) {
                $task->update(['position' => $index + 1]);
            });
    
        // Return a response indicating success
        return response()->json(['message' => 'Values updated successfully']);
    }
 



   




    /**
     * Remove the specified resource from storage.
     */
    // TaskController.php

    public function destroy(Task $task)
    {
        $this->authorize('delete', $task);

        // Get the status and position of the task being deleted
        $status = $task->status;
        $position = $task->position;

        // Delete the task
        $task->delete();

        // Update positions of remaining tasks with the same status
        Task::where('status', $status)
            ->where('position', '>', $position)
            ->decrement('position');

        // Update positions to ensure consecutive numbering from 1
        Task::where('status', $status)
            ->orderBy('position')
            ->get()
            ->each(function ($task, $index) {
                $task->update(['position' => $index + 1]);
            });

        return redirect()
            ->route('dashboard')
            ->with('success', "Task has been deleted!");
    }


}
