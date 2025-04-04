<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmptyResource;
use App\Http\Resources\KlientCollection;
use App\Http\Resources\KlientResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\klientet;
use App\Services\KlientService;
use App\Services\ProduktService;
use Exception;
use Illuminate\Http\Request;

class KlientController extends Controller
{
    use ApiResponseTrait;

    protected KlientService $KlientService;

    public function __construct(KlientService $KlientService)
    {
        $this->KlientService=$KlientService;
    }

    public function index()
    {
        try {
            $klient=$this->KlientService->all();
            if($klient->isEmpty()){
                return $this->okNoRecords();
            }
            return $this->okWithCollection(new KlientCollection($klient));
            
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
            $klient=$this->KlientService->save($request);
            return $this->created(new KlientResource($klient));
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
            $Klient=$this->KlientService->find($id);
            if($Klient){
                return $this->okWithResource(new KlientResource($Klient));
            }
            return $this->notFound();
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit()
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id)
    {
         
        try {
            $klient=$this->KlientService->find($id);
            if($klient){
                $klient=$this->KlientService->update($request,$id);
                return $this->okWithResource(new KlientResource($klient));
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
            $klient=$this->KlientService->find($id);
            if($klient){
                $this->KlientService->delete($id);
                return $this->deleted(new EmptyResource($klient));
            }
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }
}
