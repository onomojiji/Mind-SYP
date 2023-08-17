<?php

namespace App\Imports;

use App\Models\Personnel;
use App\Models\Pointage;
use App\Models\PointageImport;
use App\Models\Poste;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Concerns\ToArray;

class PointagesImport implements ToArray
{

    public function array(array $array)
    {
        for ($i=2; $i<count($array); $i++){

            // touver le personnel
            $isPersonnel = Personnel::where("prenom", $array[$i][1])->where("nom", $array[$i][0])->where("sexe", $array[$i][2])->first();
            $isPersonnel ? $personnel = $isPersonnel : $personnel = Personnel::create([
                "prenom" => $array[$i][1],
                "nom" => $array[$i][0],
                "sexe" => $array[$i][2],
            ]);

            // vérification du nom de la structure
            // Si ce nom est égal à RESPONSABLES
            if ($array[$i][3] == "RESPONSABLES"){ // si c'est un responsable, alors
                $structurePersonnel = Str::remove([" ", "CHEF", "DIRECTEUR"], $array[$i][4]);
                // on teste voir si l4utilisateur existe
                $isUser = User::where("email", Str::lower(Str::remove([" ", "-", "M.", "Mme.", "Mr", "Mrs","Miss"], $array[$i][0].$array[$i][1]))."@minddevel.gov.cm")->first();
                // on crès un utilisateur associé si il n4existe pas
                $isUser?
                     :
                    User::create(
                    [
                        "email" => Str::lower(Str::remove([" ", "-", "M.", "Mme.", "Mr", "Mrs","Miss"], $array[$i][0].$array[$i][1]))."@minddevel.gov.cm",
                        "password" => Hash::make("Mindsyp2023"),
                        "personnel_id" => $personnel->id
                    ]
                );
            }else{
                $structurePersonnel = $array[$i][3];
            }

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

            $date = date("Y-m-d", strtotime($array[$i][5]));
            $array[$i][6] != null ? $entree = date("H:i:s", strtotime($array[$i][6])) : $entree = null;
            $array[$i][7] != null ? $sortie = date("H:i:s", strtotime($array[$i][7])) : $sortie = null;
            $array[$i][8] != null ? $total = number_format($array[$i][8], 1, '.', '') : $total = null;

            // trouver le pointage
            $isPointage = Pointage::where("date", $date)
                ->where("entree", $entree)
                ->where("sortie", $sortie)
                ->where("total", $total)
                ->where("personnel_id", $personnel->id)
                ->where("structure_id", $structure->id)
                ->where("poste_id", $poste->id)
                ->first();

            // création du pointage
            $isPointage ? $pointage = $isPointage : $pointage = Pointage::create([
                "date" => $date,
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
