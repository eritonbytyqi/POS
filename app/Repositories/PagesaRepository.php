<?php

namespace App\Repositories;

use App\Models\Fatura;
use App\Models\Pagesa;
use App\Models\Shitje;
use App\Repositories\IElequent\IPagesaRepository;

class PagesaRepository extends BaseRepository implements IPagesaRepository
{
    public function __construct(Pagesa $model)
    {
        parent::__construct($model);
    }

    public function bejePagesen($shitje_id, $shuma, $metoda)
    {
        // Gjej shitjen duke përdorur findOrFail (nuk ka nevojë për kontroll tjetër)
        $shitje = Shitje::findOrFail($shitje_id);

        // Llogarit totalin e pagesave të bëra deri tani për këtë shitje
        $total = Pagesa::where('shitje_id', $shitje_id)->sum('shuma');
        $newShumaTotale = $total + $shuma;

        // Përditëso statusin e shitjes në bazë të pagesës
        if ($newShumaTotale >= $shitje->shuma) {
            $shitje->statusi = 'perfunduar'; // Shitja është e paguar plotësisht
        } elseif ($newShumaTotale > 0) {
            $shitje->statusi = 'pages_pjesshme'; // Shitja ka një pagesë të pjesshme
        }

        $shitje->save(); // Përshtat statusin në shitje

        // Krijo një regjistrim të ri për pagesën
        return Pagesa::create([
            'shitje_id' => $shitje_id,
            'shuma' => $shuma,
            'lloji' => $metoda,
            'data_pageses' => now(), // Data e pagesës
        ]);
    }
}
