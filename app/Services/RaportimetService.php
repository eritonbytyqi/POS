<?php    
namespace App\Services;

use App\Http\Resources\RaportimetResource;
use App\Models\Raportimet;
use App\Models\Shitje;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Request;

class RaportimetService
{
    // Metoda për raportet javore
    public function perJaven($java, $viti)
    {
        // Përdorim Carbon për të krijuar datën e fillimit dhe të fundit të javës
        $fillimi = Carbon::create($viti, 1, 1)->addWeeks($java - 1)->startOfWeek();  // Fillimi i javës
        $fundi = Carbon::create($viti, 1, 1)->addWeeks($java - 1)->endOfWeek();  // Fundi i javës
    
        // Filtrimi i shitjeve për javën e caktuar
        $shitjet = Shitje::whereBetween('created_at', [$fillimi, $fundi])->get();
    
        return $shitjet;
    }
    
    // Metoda për raportet mujore
    public function perMuajin($muaji, $viti)
    {
        // Përdorim Carbon për të krijuar datën e parë dhe të fundit të muajit
        $fillimi = Carbon::createFromDate($viti, $muaji, 1)->startOfMonth();  // Fillimi i muajit
        $fundi = Carbon::createFromDate($viti, $muaji, 1)->endOfMonth();  // Fundi i muajit
    
        // Filtrimi i shitjeve për muajin e caktuar
        $shitjet = Shitje::whereBetween('created_at', [$fillimi, $fundi])->get();
    
        return $shitjet;
    }
    

    // Metoda për raportet vjetore
    public function perVitin()
    {
        $dataStart = Carbon::now()->startOfYear();
        $dataEnd = Carbon::now()->endOfYear();

        return Raportimet::whereHas('shitje', function ($query) use ($dataStart, $dataEnd) {
            $query->whereBetween('created_at', [$dataStart, $dataEnd]);
        })->get();
    }

    // Metoda për raportet për një datë specifike
    // public function perDate($data)
    // {
    //     // Përdorim Carbon për të krijuar një datë dhe për ta formatuar atë
    //     $data = Carbon::parse($data);
    
    //     // Filtrimi i shitjeve për datën e kërkuar
    //     $shitjet = Shitje::whereDate('created_at', $data)->get();
    
    //     return $shitjet;
    // }


    // Ruaj një raport të ri
    public function save($request)
    {
        $raporti = new Raportimet();
        $raporti->shitje_id = $request->input('shitje_id');
        $raporti->totali = $request->input('totali');
        $raporti->created_at = now();
        $raporti->save();
        return $raporti;
    }
    public function perDateRange($fillimi, $fundi)
    {
        // Përdorim Carbon për të siguruar që datat janë të formatuara siç duhet
        $fillimi = Carbon::parse($fillimi)->startOfDay();  // Krijojmë fillimin e intervalit (duke i vendosur orën në 00:00:00)
        $fundi = Carbon::parse($fundi)->endOfDay();  // Krijojmë fundin e intervalit (duke i vendosur orën në 23:59:59)
    
        // Filtrimi i shitjeve që ndodhin mes këtyre dy datave
        $shitjet = Shitje::whereBetween('created_at', [$fillimi, $fundi])->get();
    
        return $shitjet;
    }
    
    // Gjej një raport nga ID
    public function find($id)
    {
        return Raportimet::find($id);
    }

    // Përditëso një raport
    public function update($request, $id)
    {
        $raporti = Raportimet::find($id);
        if ($raporti) {
            $raporti->shitje_id = $request->input('shitje_id');
            $raporti->totali = $request->input('totali');
            $raporti->updated_at = now();
            $raporti->save();
            return $raporti;
        }
        return null;
    }

    // Fshi një raport nga ID
    public function delete($id)
    {
        $raporti = Raportimet::find($id);
        if ($raporti) {
            $raporti->delete();
        }
    }

    public function perDate($fillimi, $fundi)
    {
        // Llogaritni totalin për një periudhë specifike (fillimi dhe fundi)
        return Raportimet::whereBetween('created_at', [$fillimi, $fundi])
                         ->sum('cmimi'); // Këtu "cmimi" është kolona që mban çmimet
    }
    

}
