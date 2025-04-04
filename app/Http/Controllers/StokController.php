<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\StokService;  // Shërbimi për stokun
use App\Http\Resources\StokResource;  // Resursi për stokun
use App\Http\Resources\StokCollection;  // Koleksioni i stokut
use App\Http\Resources\EmptyResource;  // Për resurset bosh
use App\Http\Traits\Helpers\ApiResponseTrait;
use Exception;

class StokController extends Controller
{
    use ApiResponseTrait;
    protected StokService $StokService;

    public function __construct(StokService $StokService)
    {
        $this->StokService = $StokService;
    }

    /**
     * Shfaq të gjitha stoket.
     */
    public function index()
    {
        try {
            $stoqet = $this->StokService->all(); // Merr të gjitha stoket
            if ($stoqet->isEmpty()) {
                return $this->okNoRecords();
            }
            return $this->okWithCollection(new StokCollection($stoqet));
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim: ' . $e->getMessage());
        }
    }

    /**
     * Ruaj një stok të ri.
     */
    public function store(Request $request)
    {
        try {
            $stok = $this->StokService->addStock($request);
            return $this->created(new StokResource($stok));
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Shfaq një stok të caktuar.
     */
    public function show($id)
    {
        try {
            $stok = $this->StokService->find($id); // Gjej stokun me ID
            if ($stok) {
                return $this->okWithResource(new StokResource($stok));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Përshtat stokun.
     */
    public function update(Request $request, $id)
    {
        try {
            $stok = $this->StokService->find($id); // Gjej stokun me ID
            if ($stok) {
                $stok = $this->StokService->update($request, $id); // Përshtat stokun
                return $this->okWithResource(new StokResource($stok));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Fshi stokun nga ruajtja.
     */
    public function destroy($id)
    {
        try {
            $stok = $this->StokService->find($id); // Gjej stokun
            if ($stok) {
                $this->StokService->delete($id); // Fshi stokun
                return $this->deleted(new EmptyResource($stok));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }
}
