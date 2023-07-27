<?php

namespace App\Imports;

use App\Models\PointageImport;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToArray;

class PointagesImport implements ToArray
{

    public function array(array $array)
    {
        for ($i=2; $i<count($array); $i++){
            PointageImport::create([
                "prenom" => $array[$i][0],
                "nom" => $array[$i][1],
                "sexe" => $array[$i][2],
                "structure" => $array[$i][3],
                "poste" => $array[$i][4],
                "date" => $array[$i][5],
                "entree" => $array[$i][6],
                "sortie" => $array[$i][7],
                "total" => $array[$i][8],
            ]);
        }
    }
}
