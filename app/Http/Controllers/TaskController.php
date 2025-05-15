<?php

namespace App\Http\Controllers;

use App\Http\Requests\Requests\StoreTaskRequest;
use App\Http\Resources\Resources\TaskResource;
use App\Models\Task;
use App\Traits\HttpResponses;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    use HttpResponses;
    public function index()
    {
        $tasks = TaskResource::collection(Task::where('user_id', Auth::user()->id)->get());
        return $this->success($tasks, 'Tasks Fetched Successfully', 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreTaskRequest $request)
    {
        $request->validated($request->all());
        $task = Task::create([
            'name' => $request->name,
            'description' => $request->description,
            'priority' => $request->priority,
            'user_id' => Auth::user()->id
        ]);
        $taskResource = new TaskResource($task);
        return $this->success([
            'task' => $taskResource
        ], 'Task Created Successfully', 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Task $task)
    {
        /* if (Auth::user()->id !== $task->user_id) {
            return $this->error(null, 'You are not authorized to make this request', 403);
        } */
        if (!isNotAuthorized($task->user_id)) {
            return $this->error(null, 'You are not authorized to make this request', 403);
        }
        $taskResource = new TaskResource($task);
        return $this->success([
            'task' => $taskResource
        ], 'Task Fetched Successfully', 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Task $task)
    {
        /*  if (Auth::user()->id !== $task->user_id) {
            return $this->error(null, 'You are not authorized to make this request', 403);
        } */
        if (!isNotAuthorized($task->user_id)) {
            return $this->error(null, 'You are not authorized to make this request', 403);
        }
        $task->update($request->all());
        $taskResource = new TaskResource($task);
        return $this->success([
            'task' => $taskResource
        ], 'Task Updated Successfully', 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Task $task)
    {
        /* if (Auth::user()->id !== $task->user_id) {
            return $this->error(null, 'You are not authorized to make this request', 403);
        } */
        if (!isNotAuthorized($task->user_id)) {
            return $this->error(null, 'You are not authorized to make this request', 403);
        }
        $task->delete();
        return $this->success(null, 'Task Deleted Successfully', 200);
    }
}
