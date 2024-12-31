<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Http\Resources\EmptyResource;
use App\Http\Resources\ProjectCollection;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;
use Exception;

class ProjectController extends Controller
{
    protected ProjectService $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService=$projectService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        try {
            $projects=$this->projectService->all();
            if($projects->isEmpty()){
                return $this->okNoRecords();
            }
            return $this->okWithCollection(new ProjectCollection($projects));
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
    public function store(ProjectRequest $request)
    {
        try {
            $project=$this->projectService->save($request);
            return $this->created(new ProjectResource($project));
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
            $project=$this->projectService->find($id);
            if($project){
                return $this->okWithResource(new ProjectResource($project));
            }
            return $this->notFound();
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $project=$this->projectService->find($id);
            if($project){
                $project=$this->projectService->update($request,$id);
                return $this->okWithResource(new ProjectResource($project));
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
            $project=$this->projectService->find($id);
            if($project){
                $this->projectService->delete($id);
                return $this->deleted(new EmptyResource());
            }
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }
}
