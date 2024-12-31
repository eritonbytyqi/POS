<?php

namespace App\Services;

use App\Repositories\ProjectRepository;

class ProjectService{

    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->projectRepository=$projectRepository;
    }
    public function all($pageSize=0){
        return $this->projectRepository->all($pageSize);
    }
    public function find($id){
        return $this->projectRepository->find($id);
    }
    public function save($request){
        $attributes=$request->input();
        $project=$this->projectRepository->create($attributes);
        return $project;
    }
    public function update($request,$id){
        $attributes=$request->input();
        $project=$this->projectRepository->update($attributes,$id);
        return $project;
    }
    public function delete($id){
        return $this->projectRepository->delete($id);
    }
}
