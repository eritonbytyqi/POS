<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmptyResource;
use App\Http\Resources\UserCollection;
use App\Http\Resources\UserResource;
use App\Models\TaskList;
use App\Models\User;
use App\Services\UserService;
use Illuminate\Support\Facades\Log;

use Illuminate\Http\Request;
use Exception;

class UserController extends Controller
{

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->userService=$userService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
           
            $users=$this->userService->all();
            if($users->isEmpty()){
                return $this->okNoRecords();
            }
            return $this->okWithCollection(new UserCollection($users));
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
            $user=$this->userService->create($request);
            return $this->created(new UserResource($user));
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
            $user=$this->userService->find($id);
            if($user){
                return $this->okWithResource(new UserResource($user));
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
            $user=$this->userService->find($id);
            if($user){
                $user=$this->userService->update($request,$id);
                return $this->okWithResource(new UserResource($user));
            }
            return $this->notFound();
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }

    public function destroy($id)
    {
        try {
            $user=$this->userService->find($id);
            if($user){
                $this->userService->delete($id);
                return $this->deleted(new EmptyResource($user));
            }
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }


public function getUsersDeleted()
{
    try {
       
        $deletedUsers = User::onlyTrashed()->get();

        return response()->json($deletedUsers);
    } catch (\Exception $e) {
        return $this->respondError('Something went wrong!', $e);

    }
}

    public function restoreDeletedUser($id)
    {
        try {
         
            $user = User::withTrashed()->find($id);
    
            if ($user) {
                if ($user->trashed()) {
                    $user->restore();
    return response()->json([ 'message' => 'User restored successfully.',
         'data' => new UserResource($user)
                    ], 200);
                } else {
                    return response()->json([
                        'message' => 'User is not deleted.'], 400); 
                }
            } else {
                return response()->json([
                    'message' => 'User not found.'], 404); 
            }
        } catch (Exception $e) {
            return response()->json([
                'message' => 'Something went wrong.','error' => $e->getMessage()
            ], 500); 
        }
    }

    

    public function forceDelete($id)
{
    try {
        $user = User::withTrashed()->find($id);

        if ($user) {
            $user->forceDelete();
            return $this->deleted(new EmptyResource( $user));

        }

    } catch (Exception $e) {
        return $this->respondError('Something went wrong!', $e);


    }
}

}

