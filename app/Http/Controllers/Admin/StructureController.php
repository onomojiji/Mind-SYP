<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Personnel;
use App\Models\Pointage;
use App\Models\Poste;
use App\Models\Structure;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class StructureController extends Controller
{
    public function index(Request $request,int $id){

        $mois = $request->mois;
        $annee = $request->annee;

        $dates = [];
        $datesEntree = [];
        $datesSortie = [];
        $datesTotal = [];

        $personnels = [];

        $hme = $hms = $mme = $mms = 0;

        if ($mois = $annee == null){
            $pointages = Pointage::where("structure_id", $id)->orderBy("date")->get();

            $pointagesReussis = Pointage::where("structure_id", $id)->where("entree","!=", null)->where("sortie", "!=", null)->get();

            $pointagesEchoue = DB::table('pointages')
                ->where('structure_id', '=', $id)
                ->where(function (Builder $query) {
                    $query->where('entree', null)
                        ->orWhere('sortie', null);
                })
                ->get();

            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');

            $period = CarbonPeriod::create('' . $start->year .'-' . $start->month.'-' .$start->day.'', ''.$end->year.'-'. $end->month.'-'.$end->day.'');
            foreach ($period as $date) {
                array_push($dates, date("d-M-Y", strtotime($date)));
            }

            // algorithme d'ajout des heures moyennes par date
            foreach ($dates as $date){
                $allDayPointages = Pointage::where("date", date("Y-m-d", strtotime($date)))
                    ->where("structure_id", $id)
                    ->get();

                $hmej = $hmsj = 0;

                if (count($allDayPointages) > 0){

                    foreach ($allDayPointages as $pjr){
                        $hmej += date('H', strtotime($pjr->entree));
                        $hmsj += date('H', strtotime($pjr->sortie));
                    }

                    $hmej = intdiv($hmej, count($allDayPointages));
                    $hmsj = intdiv($hmsj, count($allDayPointages));
                    $total = $hmsj - $hmej;

                }

                if ($hmej == 0 && $hmsj != 0){
                    array_push($datesEntree, "");
                    array_push($datesTotal, "");
                }elseif ($hmej != 0 && $hmsj == 0){
                    array_push($datesSortie, "");
                    array_push($datesTotal, "");
                }elseif ($hmej == 0 && $hmsj == 0){
                    array_push($datesEntree, "");
                    array_push($datesSortie, "");
                    array_push($datesTotal, "");
                }else{
                    array_push($datesEntree, $hmej);
                    array_push($datesSortie, $hmsj);
                    array_push($datesTotal, $total);
                }

            }

            // Fin

        }else{

            $pointages = Pointage::where("structure_id", $id)
                ->where("annee", $annee)
                ->where("mois", $request->mois)
                ->orderBy("date")
                ->get();

            $pointagesReussis = Pointage::where("structure_id", $id)
                ->where("annee", $annee)
                ->where("mois", $request->mois)
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

            $year = $annee;
            $month = $request->mois;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d');
            $date_2 = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');

            $period = CarbonPeriod::create($date_1, $date_2);

            foreach ($period as $date) {
                array_push($dates, date("d-M-Y", strtotime($date)));
            }

            // algorithme d'ajout des heures moyennes par date
            foreach ($period as $date){
                $allDayPointages = Pointage::where("date", date("Y-m-d", strtotime($date)))
                    ->where("structure_id", $id)
                    ->get();

                $hmej = $hmsj = 0;

                if (count($allDayPointages) > 0){

                    foreach ($allDayPointages as $pjr){
                        $hmej += date('H', strtotime($pjr->entree));
                        $hmsj += date('H', strtotime($pjr->sortie));
                    }

                    $hmej = intdiv($hmej, count($allDayPointages));
                    $hmsj = intdiv($hmsj, count($allDayPointages));
                    $total = $hmsj - $hmej;

                }

                if ($hmej == 0 && $hmsj != 0){
                    array_push($datesEntree, "");
                    array_push($datesTotal, "");
                }elseif ($hmej != 0 && $hmsj == 0){
                    array_push($datesSortie, "");
                    array_push($datesTotal, "");
                }elseif ($hmej == 0 && $hmsj == 0){
                    array_push($datesEntree, "");
                    array_push($datesSortie, "");
                    array_push($datesTotal, "");
                }else{
                    array_push($datesEntree, $hmej);
                    array_push($datesSortie, $hmsj);
                    array_push($datesTotal, $total);
                }

            }

            // Fin

        }

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

                    if ($request->annee = $request->mois == null){
                        $nbPoints = count($personnel->pointages()->get());
                        $nbPointReussis = count($personnel->pointages()->where("entree","!=",null)->where("sortie","!=",null)->get());
                    }else{
                        $nbPoints = count($personnel->pointages()->where("mois", $request->mois)->where("annee", $annee)->get());

                        $nbPointReussis = count($personnel->pointages()->where("mois", $request->mois)->where("annee", $annee)->where("entree","!=",null)->where("sortie","!=",null)->get());
                    }

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
                        "nbPointsReussis" => $nbPointReussis,
                    ];
                }

            }
        }


        return view(
            'dashboards.structure',
            [
                "structure" => Structure::findOrfail($id),
                "personnels" => $personnels,
                "nbPointages" => $pointages,
                "pointagesSuccess" => $pointagesReussis,
                "pointagesFail" => $pointagesEchoue,
                "echoues" => $echouePointages,
                'hme' => intdiv($hme,1),
                'mme' => $mme,
                'hms' => intdiv($hms,1),
                'mms' => $mms,
                "dates" => $dates,
                "datesEntree" => $datesEntree,
                "datesSortie" => $datesSortie,
                "datesTotal" => $datesTotal
            ]
        );

    }

    public function show(Request $request, int $structure_id ,$personnel_id){

        $mois = $request->mois;
        $annee = $request->annee;

        $personnel = Personnel::find($personnel_id);
        $structure = Structure::find($structure_id);

        $hme = $hms = $mme = $mms = 0;

        $dates = [];
        $datesEntree = [];
        $datesSortie = [];
        $datesTotal = [];

        $hme = $hms = $mme = $mms = 0;

        if ($mois = $annee == null){
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

            $start = new Carbon('first day of last month');
            $end = new Carbon('last day of last month');

            $period = CarbonPeriod::create('' . $start->year .'-' . $start->month.'-' .$start->day.'', ''.$end->year.'-'. $end->month.'-'.$end->day.'');
            foreach ($period as $date) {
                array_push($dates, date("d-M-Y", strtotime($date)));
            }

            // algorithme d'ajout des heures moyennes par date
            foreach ($dates as $date){
                $allDayPointages = Pointage::where("date", date("Y-m-d", strtotime($date)))
                    ->where("structure_id", $structure_id)
                    ->where("personnel_id", $personnel_id)
                    ->get();

                $hmej = $hmsj = 0;

                if (count($allDayPointages) > 0){

                    foreach ($allDayPointages as $pjr){
                        $hmej += date('H', strtotime($pjr->entree));
                        $hmsj += date('H', strtotime($pjr->sortie));
                    }

                    $hmej = intdiv($hmej, count($allDayPointages));
                    $hmsj = intdiv($hmsj, count($allDayPointages));
                    $total = $hmsj - $hmej;

                }

                if ($hmej == 0 && $hmsj != 0){
                    array_push($datesEntree, "");
                    array_push($datesTotal, "");
                }elseif ($hmej != 0 && $hmsj == 0){
                    array_push($datesSortie, "");
                    array_push($datesTotal, "");
                }elseif ($hmej == 0 && $hmsj == 0){
                    array_push($datesEntree, "");
                    array_push($datesSortie, "");
                    array_push($datesTotal, "");
                }else{
                    array_push($datesEntree, $hmej);
                    array_push($datesSortie, $hmsj);
                    array_push($datesTotal, $total);
                }

            }

            // Fin

        }else{

            $pointages = Pointage::where("structure_id", $structure_id)
                ->where("personnel_id", $personnel_id)
                ->where("annee", $annee)
                ->where("mois", $request->mois)
                ->orderBy("date")
                ->get();

            $pointagesReussis = Pointage::where("structure_id", $structure_id)
                ->where("personnel_id", $personnel_id)
                ->where("annee", $annee)
                ->where("mois", $request->mois)
                ->where("entree","!=", null)
                ->where("sortie", "!=", null)
                ->get();

            $pointagesEchoue = DB::table('pointages')
                ->where("annee", $annee)
                ->where("mois", $request->mois)
                ->where("structure_id", $structure_id)
                ->where("personnel_id", $personnel_id)
                ->where(function (Builder $query) {
                    $query->where('entree', null)
                        ->orWhere('sortie', null);
                })
                ->get();

            $year = $annee;
            $month = $request->mois;
            $date_1 = Carbon::create($year, $month)->startOfMonth()->format('Y-m-d');
            $date_2 = Carbon::create($year, $month)->lastOfMonth()->format('Y-m-d');

            $period = CarbonPeriod::create($date_1, $date_2);
            foreach ($period as $date) {
                array_push($dates, date("d-M-Y", strtotime($date)));
            }

            // algorithme d'ajout des heures moyennes par date
            foreach ($dates as $date){
                $allDayPointages = Pointage::where("date", date("Y-m-d", strtotime($date)))
                    ->where("structure_id", $structure_id)
                    ->where("personnel_id", $personnel_id)
                    ->get();

                $hmej = $hmsj = 0;

                if (count($allDayPointages) > 0){

                    foreach ($allDayPointages as $pjr){
                        $hmej += date('H', strtotime($pjr->entree));
                        $hmsj += date('H', strtotime($pjr->sortie));
                    }

                    $hmej = intdiv($hmej, count($allDayPointages));
                    $hmsj = intdiv($hmsj, count($allDayPointages));
                    $total = $hmsj - $hmej;

                }

                if ($hmej == 0 && $hmsj != 0){
                    array_push($datesEntree, "");
                    array_push($datesTotal, "");
                }elseif ($hmej != 0 && $hmsj == 0){
                    array_push($datesSortie, "");
                    array_push($datesTotal, "");
                }elseif ($hmej == 0 && $hmsj == 0){
                    array_push($datesEntree, "");
                    array_push($datesSortie, "");
                    array_push($datesTotal, "");
                }else{
                    array_push($datesEntree, $hmej);
                    array_push($datesSortie, $hmsj);
                    array_push($datesTotal, $total);
                }

            }

            // Fin

        }


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
                "nbPointages" => $pointages,
                "pointagesSuccess" => $pointagesReussis,
                "pointagesFail" => $pointagesEchoue,
                "echoues" => $echouePointages,
                'hme' => intdiv($hme,1),
                'mme' => $mme,
                'hms' => intdiv($hms,1),
                'mms' => $mms,
                'structure' => $structure,
                "dates" => $dates,
                "datesEntree" => $datesEntree,
                "datesSortie" => $datesSortie,
                "datesTotal" => $datesTotal
            ]
        );

    }
}
