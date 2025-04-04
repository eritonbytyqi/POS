<?php

namespace App\Http\Controllers;

use App\Http\Requests\PagesaRequest;
use App\Http\Resources\EmptyResource;
use App\Http\Resources\PagesaCollection;
use App\Http\Resources\PagesaResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Services\PagesaService;
use Exception;
use Illuminate\Http\Request;

class PagesaController extends Controller
{
    use ApiResponseTrait;

    protected PagesaService $PagesaService;

    public function __construct(PagesaService $PagesaService)
    {
        $this->PagesaService = $PagesaService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $pagesat = $this->PagesaService->all();
        
            if ($pagesat->isEmpty()) {
                return $this->okNoRecords(); // Kthe përgjigje kur nuk ka asnjë pagesë
            }
            return $this->okWithCollection(new PagesaCollection($pagesat)); // Kthe përgjigje me koleksion të pagesave
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            $pagesa = $this->PagesaService->makePayment($request);
    
            return $this->created(new PagesaResource($pagesa));
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }
    
 

  public function show($id)
{
    try {
        $pagesa = $this->PagesaService->find($id); // Gjej pagesën me ID

        // Kontrollo nëse pagesa ekziston
        if ($pagesa) {
            return $this->okWithResource(new PagesaResource($pagesa)); // Kthe përgjigje me pagesën
        }

        // Kthe një përgjigje "not found" kur nuk ekziston një pagesë me këtë ID
        return $this->notFound(); // Mund të kthehet një përgjigje me kodin 404 për "not found"
    } catch (Exception $e) {
        // Në rast të një gabimi tjetër, kthe përgjigjen e gabimit
        return $this->respondError('Diçka shkoi gabim!', $e);
    }
}


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        try {
            $pagesa = $this->PagesaService->find($id); // Gjej pagesën me ID
            if ($pagesa) {
                $pagesa = $this->PagesaService->update($request, $id); // Përditëso pagesën
                return $this->okWithResource(new PagesaResource($pagesa)); // Kthe përgjigje me pagesën e përditësuar
            }
            return $this->notFound(); // Nëse pagesa nuk u gjet, kthe "not found"
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);

        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $pagesa = $this->PagesaService->find($id); // Gjej pagesën me ID
            if ($pagesa) {
                $this->PagesaService->delete($id); // Fshij pagesën
                return $this->deleted(new EmptyResource($pagesa)); // Kthe përgjigje që pagesa u fshi
            }
            return $this->notFound(); // Nëse pagesa nuk u gjet, kthe "not found"
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);

        }
    }
}
