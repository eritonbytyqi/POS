<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmptyResource;
use App\Http\Resources\TaskCollection;
use App\Http\Resources\TaskResource;
use App\Models\Task;
use App\Services\TaskService;
use Illuminate\Http\Request;
use Exception;

class TaskController extends Controller
{
    protected TaskService $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService=$taskService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $tasks=$this->taskService->all();
            if($tasks->isEmpty()){
                return $this->okNoRecords();
            }
            return $this->okWithCollection(new TaskCollection($tasks));
        }catch (Exception $e){
            return $this->respondError('Somthing went wrong' . $e);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $task=$this->taskService->save($request);
            return $this->created(new TaskResource($task));
        }catch (Exception $e){
            return $this->respondError('Something went wrong!',$e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $task=$this->taskService->find($id);
            if($task){
                return $this->okWithResource(new TaskResource($task));
            }
            return $this->notFound();
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $task=$this->taskService->find($id);
            if($task){
                $taskList=$this->taskService->update($request,$id);
                return $this->okWithResource(new TaskResource($task));
            }
            return $this->notFound();
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $task=$this->taskService->find($id);
            if($task){
                $this->taskService->delete($id);
                return $this->deleted(new EmptyResource());
            }
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }
}
