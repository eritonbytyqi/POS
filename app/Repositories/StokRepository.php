<?php
namespace App\Repositories;

use App\Models\Stok;
use App\Models\stoku;
use app\Repositories;
use App\Repositories\BaseRepository;
use App\Repositories\IElequent\IStokRepository;
use App\Repositories\IElequent\IStokuRepository;

class StokRepository extends BaseRepository implements IStokRepository{

    public function __construct(Stok $model)
    {
        parent::__construct($model);
    }

    public function addStock(array $data)
    {
        $produkt_id = $data['produkt_id'];
        $sasia_re = $data['sasia_ne_stok'];
        $cmimi_ri = $data['cmimi_blerjes'];

        // Kontrollo nëse ekziston produkti në stok
        $stok = $this->model->where('produkt_id', $produkt_id)->first();

        if ($stok) {
            // Llogarit çmimin mesatar të ri
            $total_vjeter = $stok->sasia_ne_stok * $stok->cmimi_blerjes;
            $total_ri = $sasia_re * $cmimi_ri;
            $sasia_total = $stok->sasia_ne_stok + $sasia_re;

            $cmimi_mesatar = ($total_vjeter + $total_ri) / $sasia_total;

            // Përditëso stokun
            $stok->update([
                'sasia_ne_stok' => $sasia_total,
                'cmimi_blerjes' => round($cmimi_mesatar, 2),
            ]);
        } else {
            // Krijo një stok të ri
            $stok = $this->create($data);
        }

        return $stok;
    }
}
