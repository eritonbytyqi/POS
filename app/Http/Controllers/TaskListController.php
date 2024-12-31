<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskListtRequest;
use App\Http\Resources\EmptyResource;
use App\Http\Resources\TaskListCollection;
use App\Http\Resources\TaskListResource;
use App\Models\TaskList;
use App\Services\TaskListService;
use Illuminate\Http\Request;
use Exception;

class TaskListController extends Controller
{

    protected TaskListService $taskListService;

    public function __construct(TaskListService $taskListService)
    {
        $this->taskListService=$taskListService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $taskLists=$this->taskListService->all();
            if($taskLists->isEmpty()){
                return $this->okNoRecords();
            }
            return $this->okWithCollection(new TaskListCollection($taskLists));
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
    public function store(TaskListtRequest $request)
    {
        try {
            $taskList=$this->taskListService->save($request);
            return $this->created(new TaskListResource($taskList));
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
            $taskList=$this->taskListService->find($id);
            if($taskList){
                return $this->okWithResource(new TaskListResource($taskList));
            }
            return $this->notFound();
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(TaskList $taskList)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
        try {
            $taskList=$this->taskListService->find($id);
            if($taskList){
                $taskList=$this->taskListService->update($request,$id);
                return $this->okWithResource(new TaskListResource($taskList));
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
            $taskList=$this->taskListService->find($id);
            if($taskList){
                $this->taskListService->delete($id);
                return $this->deleted(new EmptyResource());
            }
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }
}
