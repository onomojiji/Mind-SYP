<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\Pointage;
use App\Models\Poste;
use App\Models\Structure;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StructureController extends Controller
{
    public function index(Request $request,int $id){

        $mois1 = $request->moisStart;
        $annee1 = $request->anneeStart;
        $mois2 = $request->moisEnd;
        $annee2 = $request->anneeEnd;

        $pointagesTotal = [
            "date" => [],
            "entree" => [],
            "sortie" => [],
        ];

        $personnels = [];

        $hme = $hms = $mme = $mms = 0;

        if ($mois1 = $mois2 = $annee1 = $annee2 == null){
            $pointages = Pointage::where("structure_id", $id)->orderBy("date")->get();

            $pointagesReussis = Pointage::where("structure_id", $id)->where("entree","!=", null)->where("sortie", "!=", null)->get();

            $pointagesEchoue = DB::table('pointages')
                ->where('structure_id', '=', $id)
                ->where(function (Builder $query) {
                    $query->where('entree', null)
                        ->orWhere('sortie', null);
                })
                ->get();
        }else{

            $pointages = Pointage::where("structure_id", $id)
                ->whereBetween("date", [date("Y-m-d", strtotime("".$annee2."-".$mois2."01")), date("Y-m-d", strtotime("".$annee1."-".$mois1."01"))])
                ->orderBy("date")
                ->get();

            $pointagesReussis = Pointage::where("structure_id", $id)
                ->whereBetween("date", [date("Y-m-d", strtotime("".$annee2."-".$mois2."01")), date("Y-m-d", strtotime("".$annee1."-".$mois1."01"))])
                ->where("entree","!=", null)
                ->where("sortie", "!=", null)
                ->get();

            $pointagesEchoue = DB::table('pointages')
                ->whereBetween("date", [date("Y-m-d", strtotime("".$annee2."-".$mois2."01")), date("Y-m-d", strtotime("".$annee1."-".$mois1."01"))])
                ->where('structure_id', '=', $id)
                ->where(function (Builder $query) {
                    $query->where('entree', null)
                        ->orWhere('sortie', null);
                })
                ->get();
        }

        $pointages = Pointage::where("structure_id", $id)->orderBy("date")->get();

        $pointagesReussis = Pointage::where("structure_id", $id)->where("entree","!=", null)->where("sortie", "!=", null)->get();

        $pointagesEchoue = DB::table('pointages')
            ->where('structure_id', '=', $id)
            ->where(function (Builder $query) {
                $query->where('entree', null)
                    ->orWhere('sortie', null);
            })
            ->get();

        $echouePointages = [];
        foreach ($pointagesEchoue as $pe){
            $personnel = Personnel::find($pe->personnel_id);
            $structure = Structure::find($pe->structure_id);
            $poste = Poste::find($pe->poste_id);
            $echouePointages[] = [
                'id' => $personnel->id,
                'nom' => $personnel->nom,
                'prenom' => $personnel->prenom,
                'sexe' => $personnel->sexe,
                'structure' => $structure->nom,
                'poste' => $poste->nom,
                'date' => $pe->date,
                'entree' => $pe->entree,
                'sortie' => $pe->sortie,
                'total' => $pe->total
            ];
        }

        foreach ($pointagesReussis as $pr){
            $hme += date('H', strtotime($pr->entree));
            $mme += date('i', strtotime($pr->entree));

            $hms += date('H', strtotime($pr->sortie));
            $mms += date('i', strtotime($pr->sortie));
        }

        if (count($pointagesReussis) > 0){
            $hme = intdiv($hme, count($pointagesReussis));
            $mme = intdiv($mme, count($pointagesReussis));
            $hms = intdiv($hms, count($pointagesReussis));
            $mms = intdiv($mms, count($pointagesReussis));
        }

        // get all structures personnels

        foreach (Personnel::orderBy("nom")->get() as $personnel){

            $pointagePersonnel = $personnel->pointages->first();

            if ($pointagePersonnel != null){

                if ($pointagePersonnel->structure_id == $id){
                    $structurePersonnel = $pointagePersonnel->structure;
                    $postePersonnel = $pointagePersonnel->poste;

                    $nbPoints = count($personnel->pointages()->get());
                    $nbPointReussis = count($personnel->pointages()->where("entree","!=",null)->where("sortie","!=",null)->get());
                    $nbPointEchoue = $nbPoints - $nbPointReussis;

                    $personnels[] = [
                        "id" => $personnel->id,
                        "nom" => $personnel->nom,
                        "prenom" => $personnel-> prenom,
                        "sexe" => $personnel->sexe,
                        "structure" => $structurePersonnel->nom,
                        "poste" => $postePersonnel->nom,
                        "nbPoints" => $nbPoints,
                        "nbPointsEchoues" => $nbPointEchoue,
                        "nbPointsReussis" => $nbPointReussis
                    ];
                }

            }
        }


        return view(
            'dashboards.structure',
            [
                "structure" => Structure::findOrfail($id),
                'pointages' => $pointagesTotal,
                "personnels" => $personnels,
                "nbPointages" => $pointages,
                "pointagesSuccess" => $pointagesReussis,
                "pointagesFail" => $pointagesEchoue,
                "echoues" => $echouePointages,
                'hme' => intdiv($hme,1),
                'mme' => $mme,
                'hms' => intdiv($hms,1),
                'mms' => $mms,
            ]
        );

    }

    public function show(int $structure_id ,$personnel_id){

        $personnel = Personnel::find($personnel_id);
        $structure = Structure::find($structure_id);

        $pointagesTotal = [
            "date" => [],
            "entree" => [],
            "sortie" => [],
        ];

        $hme = $hms = $mme = $mms = 0;

        $pointages = Pointage::where("structure_id", $structure_id)->where("personnel_id", $personnel_id)->orderBy("date")->get();

        $pointagesReussis = Pointage::where("structure_id", $structure_id)->where("personnel_id", $personnel_id)->where("entree","!=", null)->where("sortie", "!=", null)->get();

        $pointagesEchoue = DB::table('pointages')
            ->where("structure_id", $structure_id)
            ->where("personnel_id", $personnel_id)
            ->where(function (Builder $query) {
                $query->where('entree', null)
                    ->orWhere('sortie', null);
            })
            ->get();

        $echouePointages = [];
        foreach ($pointagesEchoue as $pe){
            $poste = Poste::find($pe->poste_id);
            $echouePointages[] = [
                "id" => $personnel->id,
                'nom' => $personnel->nom,
                'prenom' => $personnel->prenom,
                'sexe' => $personnel->sexe,
                'structure' => $structure->nom,
                'poste' => $poste->nom,
                'date' => $pe->date,
                'entree' => $pe->entree,
                'sortie' => $pe->sortie,
                'total' => $pe->total
            ];
        }

        foreach ($pointagesReussis as $pr){
            $hme += date('H', strtotime($pr->entree));
            $mme += date('i', strtotime($pr->entree));

            $hms += date('H', strtotime($pr->sortie));
            $mms += date('i', strtotime($pr->sortie));
        }

        if (count($pointagesReussis) > 0){
            $hme = intdiv($hme, count($pointagesReussis));
            $mme = intdiv($mme, count($pointagesReussis));
            $hms = intdiv($hms, count($pointagesReussis));
            $mms = intdiv($mms, count($pointagesReussis));
        }


        return view(
            'dashboards.personnel',
            [
                "personnel" => $personnel,
                'pointages' => $pointagesTotal,
                "nbPointages" => $pointages,
                "pointagesSuccess" => $pointagesReussis,
                "pointagesFail" => $pointagesEchoue,
                "echoues" => $echouePointages,
                'hme' => intdiv($hme,1),
                'mme' => $mme,
                'hms' => intdiv($hms,1),
                'mms' => $mms,
            ]
        );

    }
}
