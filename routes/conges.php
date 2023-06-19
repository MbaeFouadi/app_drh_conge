<?php

use App\Http\Controllers\Conges\CongesController;
use Illuminate\Support\Facades\DB;
// use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/conges', function () {
    return view('pages.conges.dash');
})->middleware(['auth'])->name('conges');

Route::get('/demande_conges', function () {
  $employe = DB::table('employers')
  ->join('conges','employers.id','=','conges.id_employe')
  ->select('employers.*','conges.*')
  ->where("employers.id",Auth::user()->id)->first();

  $emp = DB::table('employers')
  ->join('conges','employers.id','=','conges.id_employe')
  ->select('employers.*','conges.*')
  ->where("employers.id",Auth::user()->id)
  ->where("conges.is_ok",1)
  ->where("conges.annee",date('Y'))
  ->orderBy('conges.id','desc')->limit(1)->first();

  $conges = DB::table('conges')->where("id_employe",Auth::user()->id)->get();
    return view('pages.conges.demande', compact('employe','conges','emp'));
})->middleware(['auth'])->name('demande_conges');
/*

$nbresconges = DB::table('conges')->where("id_employe",Auth::user()->id)->count();
if ($nbresconges==1) {
  // code...
  $conges = DB::table('conges')->where("id_employe",Auth::user()->id)->get();
  return view('pages.conges.demande', compact('employe','conges','emp'));
} else {
  // code...
  $nbre = 30;
  return view('pages.conges.demande', compact('employe','nbre','emp'));
}
*/
//Route::get('/demande_conges',[CongesController::class, 'index'])->middleware(['Auth'])->name('demande_conges');

Route::get('/mes_conges', function () {
  $conges = DB::table('conges')->where("id_employe",Auth::user()->id)->orderBy('id','desc')->get();

    return view('pages.conges.messanger',compact('conges'));
})->middleware(['auth'])->name('mes_conges');

Route::put('/password_update/{id}',[CongesController::class, 'passwordupdate'])->name('passwordupdate');



//Route::post('/connexion',[CongesController::class, 'connexion'])->name('connexion');
