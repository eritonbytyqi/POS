<?php

namespace App\Http\Controllers;

use App\Http\Resources\EmptyResource;
use App\Http\Resources\ProduktCollection;
use App\Http\Resources\ProduktResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\Produkt;
use App\Models\produktet;
use App\Services\ProduktService;
use Exception;
use Illuminate\Http\Request;

class ProduktController extends Controller
{

    use ApiResponseTrait;

    protected ProduktService $ProduktService;

    public function __construct(ProduktService $ProduktService)
    {
        $this->ProduktService=$ProduktService;
    }

    public function index()
    {
        try {
            $Produkt=$this->ProduktService->all();
            if($Produkt->isEmpty()){
                return $this->okNoRecords();
            }
            return $this->okWithCollection(new ProduktCollection($Produkt));
            
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
            $Produkt=$this->ProduktService->save($request);
            return $this->created(new ProduktResource($Produkt));
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
            $Produkt=$this->ProduktService->find($id);
            if($Produkt){
                return $this->okWithResource(new ProduktResource($Produkt));
            }
            return $this->notFound();
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(produkt $produkt)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update( Request $request,$id)
    {
        
        try {
            $Produkt=$this->ProduktService->find($id);
            if($Produkt){
                $Produkt=$this->ProduktService->update($request,$id);
                return $this->okWithResource(new ProduktResource($Produkt));
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
            $Produkt=$this->ProduktService->find($id);
            if($Produkt){
                $this->ProduktService->delete($id);
                return $this->deleted(new EmptyResource($Produkt));
            }
        }catch (Exception $e){
            return $this->respondError('Something went wrong!', $e);
        }
    }  

    public function search(Request $request)
    {
        $searchQuery = trim($request->input('search')); // Merrni parametrin e kërkimit dhe hiqni hapësirat bosh
    
        // Kërkoni produktet që përputhen pjesërisht me emrin ose barkodin
        $produktet = Produkt::where(function ($query) use ($searchQuery) {
                $query->where('emri', 'LIKE', '%' . $searchQuery . '%')  // Përputhje pjesore për emrin
                      ->orWhere('barkodi', 'LIKE', '%' . $searchQuery . '%'); // Përputhje pjesore për barkodin
            })
            ->whereNotNull('barkodi') // Sigurohuni që barkodi nuk është NULL
            ->whereNotNull('emri') // Sigurohuni që emri nuk është NULL
            ->where('barkodi', '!=', '') // Sigurohuni që barkodi nuk është bosh
            ->where('emri', '!=', '') // Sigurohuni që emri nuk është bosh
            ->get();
    
        if ($produktet->isNotEmpty()) {
            return response()->json($produktet);
        } else {
            return response()->json(['message' => 'Nuk u gjetën produkte për kërkimin tuaj'], 404);
        }
    }
    
    
    }
   
