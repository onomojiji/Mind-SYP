<?php

namespace App\Http\Controllers;

use App\Models\Personnel;
use App\Models\Pointage;
use App\Models\Structure;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

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

    public function root()
    {
        $start = "20:24:02";
        $end = "22:22:00";

        //dd(gmdate("H:i:s", (strtotime($end) + strtotime($start)) / 2));

        $pointagesTotal = [
            "date" => [],
            "entree" => [],
            "sortie" => [],
        ];

        $personnels = [
            "structure" => [],
            "personnel" => []
        ];

        $pointages = Pointage::orderBy("date")->get();
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

        // get all minndevel personnels
        foreach (Personnel::orderBy("nom")->get() as $personnel){
            $pointagePersonnel = $personnel->pointages->first();
            if ($pointagePersonnel != null){
                $structurePersonnel = $pointagePersonnel->structure;
                $postePersonnel = $pointagePersonnel->poste;

                if(!in_array($structurePersonnel->nom, $personnels["structure"])){
                    $personnels["structure"][] = $structurePersonnel->nom;
                }
                $personnels["personnel"][] = [
                    "structure" => $structurePersonnel->nom,
                    "nom" => $personnel->nom,
                    "prenom" => $personnel-> prenom,
                    "sexe" => $personnel->sexe,
                    "poste" => $postePersonnel->nom
                ];
            }
        }

        //dd($personnels);

        return view(
            'index',
            [
                'pointages' => $pointagesTotal,
                "personnels" => $personnels,
                "nbPointages" => count($pointages),
                "pointagesSuccess" => $pointagesReussis,
                "pointagesFail" => $pointagesEchoue
            ]
        );
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
