<?php    
namespace App\Http\Controllers;

use App\Http\Requests\ShitjeRequest;
use Illuminate\Http\Request;
use App\Services\SaleService;  // Shërbimi për shitjet
use App\Http\Resources\SaleResource;  // Resursi për shitjet
use App\Http\Resources\SaleCollection;  // Koleksioni i shitjeve
use App\Http\Resources\EmptyResource;  // Për resurset bosh
use App\Http\Resources\ShitjeCollection;
use App\Http\Resources\ShitjeResource;
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\Shitje;
use App\Services\ShitjeService;
use Exception;

class ShitjeController extends Controller
{
    use ApiResponseTrait;

    protected ShitjeService $ShitjeService;

    public function __construct(ShitjeService $ShitjeService)
    {
        $this->ShitjeService = $ShitjeService;
    }
  
    public function index()
    {
        try {
            $shitjet = $this->ShitjeService->all(); // Merr të gjitha shitjet
            if ($shitjet->isEmpty()) {
                return $this->okNoRecords();
            }
            return $this->okWithCollection(new ShitjeCollection($shitjet));
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim: ' . $e->getMessage());
        }
    }

    /**
     * Shfaq formën për krijimin e një shitje të re.
     */
    public function create()
    {
        //
    }

    /**
     * Ruaj një shitje të re.
     */
    public function store(Request $request)
    {
        
        try {
            $shitja = $this->ShitjeService->save($request); // Ruaj shitjen
            return $this->created(new ShitjeResource($shitja));
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Shfaq shitjen e specifikuar.
     */
    public function show($id)
    {
        try {
            $shitja = $this->ShitjeService->find($id); // Gjej shitjen me ID
            if ($shitja) {
                return $this->okWithResource(new ShitjeResource($shitja));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Përshtat shitjen.
     */
    public function update(Request $request, $id)
    {
        try {
            $shitja = $this->ShitjeService->find($id); // Gjej shitjen me ID
            if ($shitja) {
                $shitja = $this->ShitjeService->update($request, $id); // Përshtat shitjen
                return $this->okWithResource(new ShitjeResource($shitja));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Fshi shitjen nga ruajtja.
     */
    public function destroy($id)
    {
        try {
            $shitja = $this->ShitjeService->find($id); // Gjej shitjen
            if ($shitja) {
                $this->ShitjeService->delete($id); // Fshi shitjen
                return $this->deleted(new EmptyResource($shitja));
            }
            return $this->notFound();
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }
}
