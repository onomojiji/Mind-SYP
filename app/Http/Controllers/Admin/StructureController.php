<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\Pointage;
use App\Models\Structure;

class StructureController extends Controller
{
    public function index(int $id){

        $start = "20:24:02";
        $end = "22:22:00";

        //dd(gmdate("H:i:s", (strtotime($end) + strtotime($start)) / 2));

        $pointagesTotal = [
            "date" => [],
            "entree" => [],
            "sortie" => [],
        ];

        $personnels = [];

        $pointages = Pointage::where("structure_id", $id)->orderBy("date")->get();

        $pointagesReussis = 0;
        $pointagesEchoue = 0;

        $moyEntree = "00:00:00";
        $moySortie = "00:00:00";

        foreach ($pointages as $point){
            ($point->entree == null || $point->sortie == null)? $pointagesEchoue += 1 : $pointagesReussis += 1;
            if (in_array(date("d M Y", strtotime($point->date)), $pointagesTotal["date"])){
                $moyEntree = gmdate(
                    "H:i:s", (
                    (strtotime($moyEntree) + strtotime($point->entree)) / 2
                )
                );
                $moySortie = gmdate(
                    "H:i:s", (
                    (strtotime($moySortie) + strtotime($point->sortie)) / 2
                )
                );
            }else {
                $pointagesTotal["date"][] = date("d M Y", strtotime($point->date));
                $pointagesTotal["entree"][] = $moyEntree;
                $pointagesTotal["sortie"][] = $moySortie;
            }
        }

        // get all structures personnels

        foreach (Personnel::orderBy("nom")->get() as $personnel){

            $pointagePersonnel = $personnel->pointages->first();

            if ($pointagePersonnel != null){

                if ($pointagePersonnel->structure_id == $id){
                    $structurePersonnel = $pointagePersonnel->structure;
                    $postePersonnel = $pointagePersonnel->poste;

                    $personnels[] = [
                        "nom" => $personnel->nom,
                        "prenom" => $personnel-> prenom,
                        "sexe" => $personnel->sexe,
                        "structure" => $structurePersonnel->nom,
                        "poste" => $postePersonnel->nom
                    ];
                }

            }
        }

        //dd($personnels);

        return view(
            'dashboards.structure',
            [
                "structure" => Structure::findOrfail($id),
                'pointages' => $pointagesTotal,
                "personnels" => $personnels,
                "nbPointages" => count($pointages),
                "pointagesSuccess" => $pointagesReussis,
                "pointagesFail" => $pointagesEchoue
            ]
        );

    }

    public function show(int $id){
        return view("dashboards.personnel");
    }
}
