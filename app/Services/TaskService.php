<?php

namespace App\Services;

use App\Repositories\TaskRepository;

class TaskService{

    protected $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository=$taskRepository;
    }
    public function all($pageSize=0){
        return $this->taskRepository->all($pageSize);
    }
    public function find($id){
        return $this->taskRepository->find($id);
    }
    public function save($request){
        $attributes=$request->input();
        $project=$this->taskRepository->create($attributes);
        return $project;
    }
    public function update($request,$id){
        $attributes=$request->input();
        $project=$this->taskRepository->update($attributes,$id);
        return $project;
    }
    public function delete($id){
        return $this->taskRepository->delete($id);
    }
}
