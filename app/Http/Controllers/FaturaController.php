<?php

namespace App\Http\Controllers;

use App\Http\Resources\FaturaCollection;
use App\Http\Resources\FaturaResource;
use App\Http\Resources\EmptyResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\Fatura;
use App\Services\FaturaService;
use Exception;
use Illuminate\Http\Request;

class FaturaController extends Controller
{
    use ApiResponseTrait;

    protected FaturaService $FaturaService;

    public function __construct(FaturaService $FaturaService)
    {
        $this->FaturaService = $FaturaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $faturat = $this->FaturaService->all();
            if ($faturat->isEmpty()) {
                return $this->okNoRecords();
            }
            return $this->okWithCollection(new FaturaCollection($faturat));
        } catch (Exception $e) {
            return $this->respondError('Something went wrong', $e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $fatura = $this->FaturaService->save($request);
            return $this->created(new FaturaResource($fatura));
        } catch (Exception $e) {
            return $this->respondError('Something went wrong!', $e);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $fatura = $this->FaturaService->find($id);
            if ($fatura) {
                return $this->okWithResource(new FaturaResource($fatura));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Something went wrong!', $e);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $fatura = $this->FaturaService->find($id);
            if ($fatura) {
                $fatura = $this->FaturaService->update($request, $id);
                return $this->okWithResource(new FaturaResource($fatura));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Something went wrong!', $e);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $fatura = $this->FaturaService->find($id);
            if ($fatura) {
                $this->FaturaService->delete($id);
                return $this->deleted(new EmptyResource($fatura));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Something went wrong!', $e);
        }
    }

    /**
     * Add product to the invoice
     */
   
}
