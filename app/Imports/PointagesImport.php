<?php

namespace App\Imports;

use App\Models\Personnel;
use App\Models\Pointage;
use App\Models\Poste;
use App\Models\Structure;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToArray;
use function PHPUnit\Framework\stringContains;

class PointagesImport implements ToArray
{

    public function array(array $array)
    {
        for ($i=2; $i<count($array); $i++){

            // touver le personnel
            $isPersonnel = Personnel::where("prenom", $array[$i][1])->where("nom", $array[$i][0])->where("sexe", $array[$i][2])->first();
            $isPersonnel ? ($personnel = $isPersonnel) : ($personnel = Personnel::create([
                "prenom" => $array[$i][1],
                "nom" => $array[$i][0],
                "sexe" => $array[$i][2],
            ]));

            $structurePersonnel = $array[$i][3];

            // trouver la structure
            $isStructure = Structure::where("nom", $structurePersonnel)->first();
            $isStructure ? $structure = $isStructure : $structure = Structure::create([
                "nom" => $structurePersonnel
            ]);

            // trouver le poste
            $isPoste = Poste::where("nom", $array[$i][4])->first();
            $isPoste ? $poste = $isPoste : $poste = Poste::create([
                "nom" => $array[$i][4]
            ]);

            // $dateTab = explode("/", strval($array[$i][5]));
            $date = Carbon::createFromFormat("d/m/Y", $array[$i][5]);
            $mois = $date->month;
            $annee = $date->year;
            $array[$i][6] != null ? $entree =  date("H:i:s", strtotime($array[$i][6])) : $entree = null;
            $array[$i][7] != null ? $sortie = date("H:i:s", strtotime($array[$i][7])) : $sortie = null;
            $array[$i][8] != null ? $total = number_format($array[$i][8], 1, '.', '') : $total = null;

            // trouver le pointage
            $isPointage = Pointage::where("date", $date)
                ->where("entree", $entree)
                ->where("sortie", $sortie)
                ->where("entree", $mois)
                ->where("sortie", $annee)
                ->where("total", $total)
                ->where("personnel_id", $personnel->id)
                ->where("structure_id", $structure->id)
                ->where("poste_id", $poste->id)
                ->first();

            // création du pointage
            $isPointage ? $pointage = $isPointage : $pointage = Pointage::create([
                "date" => $date,
                "mois" => $mois,
                "annee" => $annee,
                "entree" => $entree,
                "sortie" => $sortie,
                "total" => $total,
                "personnel_id" => $personnel->id,
                "structure_id" => $structure->id,
                "poste_id" => $poste->id,
            ]);
        }
    }
}
