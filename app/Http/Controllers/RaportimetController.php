<?php    
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\RaportimetService;  // Shërbimi për raportimet
use App\Http\Resources\RaportimetResource;  // Resursi për raportimet
use App\Http\Resources\RaportimetCollection;  // Koleksioni i raportimeve
use App\Http\Resources\EmptyResource;  // Për resurset bosh
use App\Http\Traits\Helpers\ApiResponseTrait;
use App\Models\Shitje;
use Carbon\Carbon;
use Exception;

class RaportimetController extends Controller
{
    use ApiResponseTrait;

    protected RaportimetService $RaportimetService;

    public function __construct(RaportimetService $RaportimetService)
    {
        $this->RaportimetService = $RaportimetService;
    }

    /**
     * Shfaq raportet për periudha të ndryshme (javore, mujore, vjetore)
     */
    // public function index()
    // {
    //     try {
    //         // Merr raportet për javën, muajin dhe vitin
    //         return response()->json([
    //             'javore' => $this->RaportimetService->perJaven(),
    //             'mujore' => $this->RaportimetService->perMuajin(),
    //             'vjetore' => $this->RaportimetService->perVitin()
    //         ]);
    //     } catch (Exception $e) {
    //         return $this->respondError('Diçka shkoi gabim!', $e);
    //     }
    // }

    /**
     * Shfaq raportet për një datë specifike
     */

    public function perDate(Request $request)
    {
        $data = $request->input('data'); // Merrni datën nga kërkesa
    
        // Thirrni shërbimin për të marrë shitjet për atë datë
        $shitjet = $this->RaportimetService->perDate($data);
    
        return response()->json([
            'shitjet' => $shitjet
        ]);
    }
    
    /**
     * Teston filtrimin për periudha të ndryshme (fillimi dhe fundi)
     */
    public function testFiltrim(Request $request)
    {
        try {
            $fillimi = $request->input('fillimi');
            $fundi = $request->input('fundi');
    
            dd($fillimi, $fundi);  // Ky do të ndalojë dhe do të tregojë vlerat e dërguara nga Postman
    
            return $this->RaportimetService->perDate($fillimi, $fundi);
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }
    public function perDateRange(Request $request)
    {
        $fillimi = $request->input('fillimi');  // Merrni datën e fillimit nga kërkesa
        $fundi = $request->input('fundi');  // Merrni datën e fundit nga kërkesa
    
        // Thirrni shërbimin për të marrë shitjet ndërmjet dy datave
        $shitjet = $this->RaportimetService->perDateRange($fillimi, $fundi);
    
        return response()->json([
            'shitjet' => $shitjet
        ]);
    }
    public function perMuajin(Request $request)
    {
        $muaji = $request->input('muaji');  // Merrni muajin nga kërkesa
        $viti = $request->input('viti');  // Merrni vitin nga kërkesa
    
        // Thirrni shërbimin për të marrë shitjet për muajin e caktuar
        $shitjet = $this->RaportimetService->perMuajin($muaji, $viti);
    
        return response()->json([
            'shitjet' => $shitjet
        ]);
    }
    public function perJaven(Request $request)
{
    $java = $request->input('java');  // Merrni numrin e javës nga kërkesa
    $viti = $request->input('viti');  // Merrni vitin nga kërkesa

    // Thirrni shërbimin për të marrë shitjet për javën e caktuar
    $shitjet = $this->RaportimetService->perJaven($java, $viti);

    return response()->json([
        'shitjet' => $shitjet
    ]);
}



public function getTotalShitje(Request $request)
{
    // Merr data nga request, nëse ka ndonjë filter, mund të përdorni këto.
    $filters = $request->all();

    // Llogaritni totalet për periudhat
    $totalDitore = $this->RaportimetService->perDate(Carbon::today()->toDateString(), Carbon::today()->toDateString()); // Totali për ditën e sotme
    $totalMuajore = $this->RaportimetService->perDate(Carbon::now()->startOfMonth()->toDateString(), Carbon::now()->endOfMonth()->toDateString()); // Totali për muajin aktual
    $totalJavore = $this->RaportimetService->perDate(Carbon::now()->startOfWeek()->toDateString(), Carbon::now()->endOfWeek()->toDateString()); // Totali për javën aktuale

    return response()->json([
        'javore' => $totalJavore,
        'mujore' => $totalMuajore,
        'ditore' => $totalDitore,
    ]);
}

    /**
     * Ruaj një raport të ri.
     */
    public function store(Request $request)
    {
        try {
            $raporti = $this->RaportimetService->save($request);  // Ruaj raportin
            return $this->created(new RaportimetResource($raporti));  // Kthe një përgjigje me resursin e raportit të ruajtur
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Shfaq një raport të caktuar.
     */
    public function show($id)
    {
        try {
            $raporti = $this->RaportimetService->find($id);  // Gjej raportin me ID
            if ($raporti) {
                return $this->okWithResource(new RaportimetResource($raporti));  // Kthe një përgjigje me raportin në formatin e kërkuar
            }
            return $this->notFound();  // Nëse raporti nuk gjendet, kthe një përgjigje "Not Found"
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Përshtat raportin.
     */
    public function update(Request $request, $id)
    {
        try {
            $raporti = $this->RaportimetService->find($id);  // Gjej raportin me ID
            if ($raporti) {
                $raporti = $this->RaportimetService->update($request, $id);  // Përshtat raportin
                return $this->okWithResource(new RaportimetResource($raporti));  // Kthe një përgjigje me raportin e përditësuar
            }
            return $this->notFound();  // Nëse raporti nuk gjendet, kthe një përgjigje "Not Found"
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }

    /**
     * Fshi raportin nga ruajtja.
     */
    public function destroy($id)
    {
        try {
            $raporti = $this->RaportimetService->find($id);  // Gjej raportin
            if ($raporti) {
                $this->RaportimetService->delete($id);  // Fshi raportin
                return $this->deleted(new EmptyResource($raporti));  // Kthe një përgjigje për fshirjen
            }
            return $this->notFound();  // Nëse raporti nuk gjendet, kthe një përgjigje "Not Found"
        } catch (Exception $e) {
            return $this->respondError('Diçka shkoi gabim!', $e);
        }
    }
}
