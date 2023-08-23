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

        $mois = $request->mois;
        $annee = $request->annee;

        $structure = Structure::find($id);

        $pointagesTotal = [
            "date" => [],
            "entree" => [],
            "sortie" => [],
        ];

        $personnels = [];



        $pointages = Pointage::where("structure_id", $id)
            ->where("annee", $annee)
            ->where("mois", $mois)
            ->orderBy("date")
            ->get();

        $pointagesReussis = Pointage::where("structure_id", $id)
            ->where("annee", $annee)
            ->where("mois", $mois)
            ->where("entree","!=", null)
            ->where("sortie", "!=", null)
            ->get();

        $pointagesEchoue = DB::table('pointages')
            ->where("annee", $annee)
            ->where("mois", $request->mois)
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

                    if ($request->annee = $request->mois == null){
                        $nbPoints = count($personnel->pointages()->get());
                        $nbPointReussis = count($personnel->pointages()->where("entree","!=",null)->where("sortie","!=",null)->get());
                    }else{
                        $nbPoints = count($personnel->pointages()->where("mois", $request->mois)->where("annee", $annee)->get());

                        $nbPointReussis = count($personnel->pointages()->where("mois", $request->mois)->where("annee", $annee)->where("entree","!=",null)->where("sortie","!=",null)->get());
                    }

                    $pointreussis = Pointage::where("personnel_id", $personnel->id)
                        ->where("annee", $annee)
                        ->where("mois", $request->mois)
                        ->where("entree","!=", null)
                        ->where("sortie", "!=", null)
                        ->get();

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

        if($mois == 1){
            $mois = "JANVIER";}
        elseif($mois == 2){
                $mois = "FEVRIER";}
            elseif($mois == 3){
                $mois = "MARS";}
            elseif($mois == 4){
                $mois = "AVRIL";}
            elseif($mois == 5){
                $mois = "MAI";}
            elseif($mois == 6){
                $mois = "JUIN";}
            elseif($mois == 7){
                $mois = "JUILLET";}
            elseif($mois == 8){
                $mois = "AOÛT";}
            elseif($mois == 9){
                $mois = "SEPTEMBRE";}
            elseif($mois == 10){
                $mois = "OCTOBRE";}
            elseif($mois == 11){
                $mois = "NOVEMBRE";}
            elseif($mois == 12){
                $mois = "DECEMBRE";}


         $pdf  = Pdf::loadView(
             'exportation',
             [
                 "structure" => $structure,
                 'pointages' => $pointagesTotal,
                 "personnels" => $personnels,
                 "nbPointages" => $pointages,
                 "pointagesSuccess" => $pointagesReussis,
                 "pointagesFail" => $pointagesEchoue,
                 "echoues" => $echouePointages,
                 "mois" => $mois,
                 "annee" => $annee,
             ]
         )->setPaper('a4', 'landscape');

        return $pdf->download($structure->nom."_".$mois."_".$annee.'.pdf');

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
