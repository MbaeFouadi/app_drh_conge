<?php

namespace App\Http\Controllers\Conges;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\Conge;
use App\Models\employer;



class CongesController extends Controller
{

    public function connexion(Request $request)
    {
        $request->validate([
            'matricule'=>'required',
            'password'=>'required',
        ]);

        auth()->attempt([
            'matricule' => $request->matricule,
            'password ' => $request->password,
        ]);
        // if(DB::table('profils')->where('matricule','=',$request->matricule)->exists())
        // {
        //     $employ = DB::table('profils')->where('matricule','=',$request->matricule)->first();
        //     $pass = $request->password;
        //     if($employ->password == $pass)
        //     {
        //         $employe = DB::table('employers')
        //         ->join('profils', 'employers.id', '=', 'profils.employe_id')
        //         ->select('employers.*')
        //         ->where("employers.id",$request->matricule)->first();

        //         return view('pages.conges.dash', compact('employe'));
        //     }else{
        //         session()->flash('erreurPassword',"Le mot de passe est incorrect.");
        //         return redirect()->route('conges');
        //     }
        //     // return $employe->matricule." ".$employe->password;

        // }else{
        //     session()->flash('erreurMatricule',"Le matricule n'est pas dans notre base");
        //     return redirect()->route('conges');
        // }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      /*$employe = DB::table('employers')
              ->join('conges','employers.id','=','conges.id_employe')
              ->where('employers.id',Auth::user()->id)
              ->select('employers.*','conges.id as idConge','conges.date_debut','conges.nombre_jour','conges.jour')
              ->first();*/
              $employe = DB::table('employers')->where("id",Auth::user()->id)->first();

      return view('pages.conges.demande');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
      $request->validate([
          'datedebut'=>'required',
          'nombre'=>'required',
      ]);
      $annee= date('Y');

      if ($request->datedebut<=date('Y-m-d')) {
        session()->flash('dateinf',"Inserez une date du future!");

          return redirect()->route('demande_conges');
      } else {


      //Congé en cours de traitement
      $congeEnCours = DB::table('conges')->where("id_employe",Auth::user()->id)->where("reponse",0)->where("annee",$annee);
      if ($congeEnCours->exists()) {
        session()->flash('encours',"Désolé, vous avez un congé qui est en cours de traitement!");

          return redirect()->route('demande_conges');
      } else {

      //Congé repondu et acceptée-->
      $congeReponduOui = DB::table('conges')->where("id_employe",Auth::user()->id)->where("reponse",1)->where("is_ok",1)->where("annee",$annee);
      //$idc = $exister->jour;
      if ($congeReponduOui->exists()) {
        $maxi = DB::table('conges')->where("id_employe",Auth::user()->id)->where("is_ok",1)->where("annee",$annee)->max('id');
        $dernier_conge = DB::table('conges')->where("id",$maxi)->where("id_employe",Auth::user()->id)->where("annee",date('Y'))->orderBy('id','desc')->limit(1)->first();
        //$resteNombre = $dernier_conge->jour-$dernier_conge->nombre_jour;
        if($dernier_conge->jour==0){
        session()->flash('jour0',"Désolé, vos jours de congés sont terminés pour cette année.");

          return redirect()->route('demande_conges');
        }elseif (($request->nombre)<=($dernier_conge->jour)) {
          $resteNombre = $dernier_conge->jour-$request->nombre;
          Conge::create([
            'date_debut'=>$request->datedebut,
            'nombre_jour'=>$request->nombre,
            'jour'=>$resteNombre,
            'id_employe'=>Auth::user()->id,
            'annee'=>$annee]);
            session()->flash('congeOk1',"Vous avez demandez un congés. Merci d'attendre une réponse.");
            return redirect()->route('mes_conges');
        } elseif(($request->nombre)>($dernier_conge->jour)) {
          session()->flash('jourGrand',"Désolé, le nombre d'jours doit être plus petit que le nombre d'jours de congés restant.");
          return redirect()->route('demande_conges');
        }

       } else {
         $max = 30;
         $nombreSaisi = $request->nombre;
         $jour = $max-$nombreSaisi;
         Conge::create([
           'date_debut'=>$request->datedebut,
           'nombre_jour'=>$nombreSaisi,
           'jour'=>$jour,
           'id_employe'=>Auth::user()->id,
           'annee'=>$annee]);
           session()->flash('congeOk2',"Vous avez demandez un congés. Merci d'attendre une réponse.");
           return redirect()->route('mes_conges');
      }
    }
   }
      //Congé repondu et refuse-->
      /*$congeReponduNon = DB::table('conges')->where("id_employe",Auth::user()->id)->where("reponse",1)->where("is_ok",0)->where("annee",$annee);
      if ($congeReponduNon->exists()) {
        // code...
      }*/
      //return redirect()->route('messanger');
    }

    public function profil($id)
    {
        $employer=employer::where('id',$id)->first();

        return view('pages.conges.profil',compact('employer'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {


      $conge = DB::table('conges')->where("id",$id)->first();

        return view('pages.conges.detail',compact('conge'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }


    public function passwordupdate(Request $request)
    {

      $request->validate([
            'ancien_mot_de_passe' => 'required',
            'mot_de_passe' => 'required|max:16|min:8',
            'confirmation_mot_de_passe' => 'required|max:16|min:8',

            'id' => 'required',
        ]);
      $id = $request->id;
      $employe = DB::table('employers')->where("id",$id)->first();
        $anc = $request->ancien_mot_de_passe;
        $pwd1 = $request->mot_de_passe;
        $pwd2 = $request->confirmation_mot_de_passe;
        //return $anc.":  ".$employe->password." != ".Hash::make($request->anc_pwd);
        if (Hash::check($anc,$employe->password)) {
          if ($pwd1==$pwd2) {
            $password = Hash::make($pwd1);
            DB::table('employers')
            ->where('id', $id)
            ->update(['password' => $password]);
            session()->flash('okPwd',"Mot de passe modifié avec succés");

            return redirect(route('profil',Auth::user()->id));
          }
          session()->flash('ErrPwd',"Ancien mot de passe incorrect");

          return redirect(route('profil',Auth::user()->id));
        }
        session()->flash('mvAncPwd',"Ancien mot de passe incorrect");

        return redirect(route('profil',Auth::user()->id));

        /*if (Hash::make($anc)==$employe->password) {
          return $anc." ".$pwd1." ".$pwd2;
        } else {
          session()->flash('anc',"L'ancien mot de passe est incorrect.");
          return redirect()->route('profil');
        }*/


    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
