<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Imports\PointagesImport;
use App\Models\Personnel;
use App\Models\Pointage;
use App\Models\Poste;
use App\Models\Structure;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

class PointageController extends Controller
{
    public function index(){

        return view("importations.index");

    }

    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {

        Excel::import(new PointagesImport, $request->file("file"));

        return redirect()->back()->with("success", "Pointages importés avec succès");
    }

    public function create(){
        return view("importations.create");
    }

    public function exportStructure(Request $request, int $id){

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

        // get all structures personnels

        foreach (Personnel::orderBy("nom")->get() as $personnel){

            $pointagePersonnel = $personnel->pointages->first();

            if ($pointagePersonnel != null){

                if ($pointagePersonnel->structure_id == $id){
                    $structurePersonnel = $pointagePersonnel->structure;
                    $postePersonnel = $pointagePersonnel->poste;

                    $nbPoints = count($personnel->pointages()->get());
                    $nbPointReussis = count($personnel->pointages()->where("entree","!=",null)->where("sortie","!=",null)->get());
                    $pointreussis = Pointage::where("personnel_id", $personnel->id)->where("entree","!=",null)->where("sortie","!=",null)->get();
                    $nbPointEchoue = $nbPoints - $nbPointReussis;

                    $hme = $hms = $mme = $mms = 0;

                    foreach ($pointreussis as $pr){
                        $hme += date('H', strtotime($pr->entree));
                        $mme += date('i', strtotime($pr->entree));

                        $hms += date('H', strtotime($pr->sortie));
                        $mms += date('i', strtotime($pr->sortie));
                    }

                    if (count($pointreussis) > 0){
                        $hme = intdiv($hme, count($pointreussis));
                        $mme = intdiv($mme, count($pointreussis));
                        $hms = intdiv($hms, count($pointreussis));
                        $mms = intdiv($mms, count($pointreussis));
                    }

                    $personnels[] = [
                        "id" => $personnel->id,
                        "nom" => $personnel->nom,
                        "prenom" => $personnel-> prenom,
                        "sexe" => $personnel->sexe,
                        "poste" => $postePersonnel->nom,
                        "nbPoints" => $nbPoints,
                        "nbPointsEchoues" => $nbPointEchoue,
                        "nbPointsReussis" => $nbPointReussis,
                        'hme' => intdiv($hme,1),
                        'mme' => $mme,
                        'hms' => intdiv($hms,1),
                        'mms' => $mms,
                    ];
                }

            }
        }

        if($mois1 == 1){
            $mois1 = "JANVIER";}
        elseif($mois1 == 2){
                $mois1 = "FEVRIER";}
            elseif($mois1 == 3){
                $mois1 = "MARS";}
            elseif($mois1 == 4){
                $mois1 = "AVRIL";}
            elseif($mois1 == 5){
                $mois1 = "MAI";}
            elseif($mois1 == 6){
                $mois1 = "JUIN";}
            elseif($mois1 == 7){
                $mois1 = "JUILLET";}
            elseif($mois1 == 8){
                $mois1 = "AOÛT";}
            elseif($mois1 == 9){
                $mois1 = "SEPTEMBRE";}
            elseif($mois1 == 10){
                $mois1 = "OCTOBRE";}
            elseif($mois1 == 11){
                $mois1 = "NOVEMBRE";}
            elseif($mois1 == 12){
                $mois1 = "DECEMBRE";}

        if($mois2 == 1){
            $mois2 = "JANVIER";}
        elseif($mois2 == 2){
            $mois2 = "FEVRIER";}
        elseif($mois2 == 3){
            $mois2 = "MARS";}
        elseif($mois2 == 4){
            $mois2 = "AVRIL";}
        elseif($mois2 == 5){
            $mois2 = "MAI";}
        elseif($mois2 == 6){
            $mois2 = "JUIN";}
        elseif($mois2 == 7){
            $mois2 = "JUILLET";}
        elseif($mois2 == 8){
            $mois2 = "AOÛT";}
        elseif($mois2 == 9){
            $mois2 = "SEPTEMBRE";}
        elseif($mois2 == 10){
            $mois2 = "OCTOBRE";}
        elseif($mois2 == 11){
            $mois2 = "NOVEMBRE";}
        elseif($mois2 == 12){
            $mois2 = "DECEMBRE";}


         $pdf  = Pdf::loadView(
             'exportation',
             [
                 "structure" => Structure::findOrfail($id),
                 'pointages' => $pointagesTotal,
                 "personnels" => $personnels,
                 "nbPointages" => $pointages,
                 "pointagesSuccess" => $pointagesReussis,
                 "pointagesFail" => $pointagesEchoue,
                 "echoues" => $echouePointages,
                 "mois1" => $mois1,
                 "mois2" => $mois2,
                 "annee1" => $annee1,
                 "annee2" => $annee2
             ]
         )->setPaper('a4', 'landscape');

        return $pdf->download($structure->nom."_".$mois1."_".$annee1."_".$mois2."_".$annee2.'.pdf');

        // return view(
        //    'exportation',
            //[
              //  "structure" => Structure::findOrfail($id),
            //    'pointages' => $pointagesTotal,
          //      "personnels" => $personnels,
        //        "nbPointages" => $pointages,
      //          "pointagesSuccess" => $pointagesReussis,
               // "pointagesFail" => $pointagesEchoue,
             //   "echoues" => $echouePointages,
           //     "mois1" => $mois1,
         //       "mois2" => $mois2,
       //         "annee1" => $annee1,
            //    "annee2" => $annee2
          //  ]
        //);

    }

}
