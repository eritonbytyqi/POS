<?php

namespace App\Services;

use App\Repositories\TaskListRepository;

class TaskListService{

    protected $taskListRepository;

    public function __construct(TaskListRepository $taskListRepository)
    {
        $this->taskListRepository=$taskListRepository;
    }
    public function all($pageSize=0){
        return $this->taskListRepository->all($pageSize);
    }
    public function find($id){
        return $this->taskListRepository->find($id);
    }
    public function save($request){
        $attributes=$request->input();
        $project=$this->taskListRepository->create($attributes);
        return $project;
    }
    public function update($request,$id){
        $attributes=$request->input();
        $project=$this->taskListRepository->update($attributes,$id);
        return $project;
    }
    public function delete($id){
        return $this->taskListRepository->delete($id);
    }
}
