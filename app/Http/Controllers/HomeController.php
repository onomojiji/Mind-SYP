<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\Pointage;
use App\Models\Poste;
use App\Models\Structure;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Matrix\Builder;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        }
        return abort(404);
    }

    public function root(Request $request)
    {

        if (Auth::user()->is_admin){

            $pointages = Pointage::orderBy("date")->get();

            $pointagesReussis = Pointage::where("entree","!=", null)->where("sortie", "!=", null)->get();

            $pointagesEchoue = Pointage::where("entree", null)->orWhere("sortie", null)->get();

            $pointagesTotal = [
                "date" => [],
                "entree" => [],
                "sortie" => [],
            ];

            $hme = $hms = $mme = $mms = 0;

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
                'index',
                [
                    'pointages' => $pointagesTotal,
                    "nbPointages" => $pointages,
                    "pointagesSuccess" => $pointagesReussis,
                    "pointagesFail" => $pointagesEchoue,
                    'hme' => intdiv($hme,1),
                    'mme' => $mme,
                    'hms' => intdiv($hms,1),
                    'mms' => $mms
                ]
            );

        }else{
            $structure = Auth::user()->personnel->pointages->first()->structure;

            $mois = $request->mois;
            $annee = $request->annee;

            $pointagesTotal = [
                "date" => [],
                "entree" => [],
                "sortie" => [],
            ];

            $personnels = [];

            $hme = $hms = $mme = $mms = 0;

            if ($mois = $annee == null){
                $pointages = Pointage::where("structure_id", $structure->id)->orderBy("date")->get();

                $pointagesReussis = Pointage::where("structure_id", $structure->id)->where("entree","!=", null)->where("sortie", "!=", null)->get();

                $pointagesEchoue = DB::table('pointages')
                    ->where('structure_id', '=', $structure->id)
                    ->where(function (\Illuminate\Contracts\Database\Query\Builder $query) {
                        $query->where('entree', null)
                            ->orWhere('sortie', null);
                    })
                    ->get();
            }else{

                $pointages = Pointage::where("structure_id", $structure->id)
                    ->where("annee", $annee)
                    ->where("mois", $request->mois)
                    ->orderBy("date")
                    ->get();

                $pointagesReussis = Pointage::where("structure_id", $structure->id)
                    ->where("annee", $annee)
                    ->where("mois", $request->mois)
                    ->where("entree","!=", null)
                    ->where("sortie", "!=", null)
                    ->get();

                $pointagesEchoue = DB::table('pointages')
                    ->where("annee", $annee)
                    ->where("mois", $request->mois)
                    ->where('structure_id', '=', $structure->id)
                    ->where(function (\Illuminate\Contracts\Database\Query\Builder $query) {
                        $query->where('entree', null)
                            ->orWhere('sortie', null);
                    })
                    ->get();
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

                    if ($pointagePersonnel->structure_id == $structure->id){
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
                            "nbPointsReussis" => $nbPointReussis
                        ];
                    }

                }
            }


            return view(
                'index',
                [
                    "structure" => $structure,
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

    }

    /*Language Translation*/
    public function lang($locale)
    {
        if ($locale) {
            App::setLocale($locale);
            Session::put('lang', $locale);
            Session::save();
            return redirect()->back()->with('locale', $locale);
        } else {
            return redirect()->back();
        }
    }

    public function updateProfile(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email'],
            'avatar' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->email = $request->get('email');

        if ($request->file('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '.' . $avatar->getClientOriginalExtension();
            $avatarPath = public_path('/images/');
            $avatar->move($avatarPath, $avatarName);
            $user->avatar =  $avatarName;
        }

        $user->update();
        if ($user) {
            Session::flash('message', 'User Details Updated successfully!');
            Session::flash('alert-class', 'alert-success');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "User Details Updated successfully!"
            // ], 200); // Status code here
            return redirect()->back();
        } else {
            Session::flash('message', 'Something went wrong!');
            Session::flash('alert-class', 'alert-danger');
            // return response()->json([
            //     'isSuccess' => true,
            //     'Message' => "Something went wrong!"
            // ], 200); // Status code here
            return redirect()->back();

        }
    }

    public function updatePassword(Request $request, $id)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);

        if (!(Hash::check($request->get('current_password'), Auth::user()->password))) {
            return response()->json([
                'isSuccess' => false,
                'Message' => "Your Current password does not matches with the password you provided. Please try again."
            ], 200); // Status code
        } else {
            $user = User::find($id);
            $user->password = Hash::make($request->get('password'));
            $user->update();
            if ($user) {
                Session::flash('message', 'Password updated successfully!');
                Session::flash('alert-class', 'alert-success');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Password updated successfully!"
                ], 200); // Status code here
            } else {
                Session::flash('message', 'Something went wrong!');
                Session::flash('alert-class', 'alert-danger');
                return response()->json([
                    'isSuccess' => true,
                    'Message' => "Something went wrong!"
                ], 200); // Status code here
            }
        }
    }
}
