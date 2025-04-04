<?php

namespace App\Repositories;

use App\Models\Pagesa;
use App\Models\Raportimet;
use App\Repositories\IElequent\IPagesaRepository;
use App\Repositories\IElequent\IRaportimetRepository;
use Carbon\Carbon;
use Illuminate\Contracts\Database\Eloquent\Builder;

class RaportimetRepository extends BaseRepository implements IRaportimetRepository{
    public function __construct(Raportimet $model)
    {
        parent::__construct($model);
    }

    public function perJaven()
    {
        return $this->filtruarSipasDates(Carbon::now()->startOfWeek(), Carbon::now()->endOfWeek());
    }

    public function perMuajin()
    {
        return $this->filtruarSipasDates(Carbon::now()->startOfMonth(), Carbon::now()->endOfMonth());
    }

    public function perVitin()
    {
        return $this->filtruarSipasDates(Carbon::now()->startOfYear(), Carbon::now()->endOfYear());
    }

    public function perDate($data)
    {
        return $this->filtruarSipasDates(Carbon::parse($data)->startOfDay(), Carbon::parse($data)->endOfDay());
    }

    private function filtruarSipasDates($fillimi, $fundi)
    {
        // Kaloni datat në formatin 'Y-m-d H:i:s'
        $fillimiFormatted = $fillimi->toDateTimeString();
        $fundiFormatted = $fundi->toDateTimeString();
    
        return Raportimet::whereIn('shitje_id', function ($q) use ($fillimiFormatted, $fundiFormatted) {
            $q->select('id')
              ->from('shitjet')
              ->whereBetween('created_at', [$fillimiFormatted, $fundiFormatted]);
        })->get();
    }
    
  

}
   


