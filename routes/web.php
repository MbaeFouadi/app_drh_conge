<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Conges\CongesController;
use App\Http\Controllers\pageController;
use App\Http\Controllers\ficheController;
use App\Http\Controllers\StatutController;
use App\Http\Controllers\periodeController;
use App\Http\Controllers\serviceController;
use App\Http\Controllers\EmployerController;
use App\Http\Controllers\fonctionController;
use App\Http\Controllers\FormationController;
use App\Http\Controllers\AvancementController;
use App\Http\Controllers\AffectationController;
use App\Http\Controllers\composantesController;
use App\Http\Controllers\affectationsController;
use App\Http\Controllers\annee_statutController;
use App\Http\Controllers\recherche_statutController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\recherche_formationController;
use App\Http\Controllers\recherche_avancementController;
use App\Http\Controllers\recherche_affectationController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/accueil', function () {
//     return view('index');
// });

Route::get('/accueil', function () {
    //$employe = DB::table('employers')->where("id",c)->first();
    // return redirect()->intended(RouteServiceProvider::HOME,compact('role'));
    $employe = DB::table('employers')
            ->join('conges','employers.id','=','conges.id_employe')
            ->where('employers.id',Auth::user()->id)
            ->select('employers.*','conges.id as idConge','conges.date_debut','conges.nombre_heure','conges.heure')
            ->first();
    return view('pages.conges.demande',compact('employe'));
    // return view('index');

})->middleware(['auth'])->name('accueil');

require __DIR__.'/auth.php';
require __DIR__.'/conges.php';
Route::get('/', function () {
    return view('pages.login');
})->name('/');

Route::post('/conges',[CongesController::class, 'store'])->name('conges');



Route::resource('/conge',CongesController::class)->middleware(['auth']);
//Route::get('/profil',[RegisteredUserController::class,'profil'])->middleware(['auth'])->name('profil');
Route::get('/profil/{id}',[CongesController::class,'profil'])->middleware(['auth'])->name('profil');

Route::post('/edit_password',[CongesController::class,'passwordupdate'])->middleware(['auth'])->name('passwordupdate');


Route::resource('/service',serviceController::class)->middleware(['auth']);
Route::resource('/fonction',fonctionController::class)->middleware(['auth']);
// Route::get('/annee',[pageController::class,'annee'])->middleware(['auth'])->name('annee');
Route::resource('/annee',periodeController::class)->middleware(['auth']);
Route::get('/affectation',[pageController::class,'affectation'])->middleware(['auth'])->name('affectation');
// Route::get('/profil',[pageController::class,'profil'])->middleware(['auth'])->name('profil');
Route::get('/matricule',[pageController::class,'recherche'])->middleware(['auth'])->name('recherche');
Route::get('/home',[pageController::class,'login'])->middleware(['auth'])->name('home');
Route::get('/recherche_formation',[recherche_formationController::class,'index'])->middleware(['auth'])->name('recherche_formation');
Route::get('/recherche_statut',[recherche_statutController::class,'index'])->middleware(['auth'])->name('recherche_statut');
Route::get('/recherche_avancement',[recherche_avancementController::class,'index'])->middleware(['auth'])->name('recherche_avancement');
Route::get('/recherche_affectation',[recherche_affectationController::class,'index'])->middleware(['auth'])->name('recherche_affectation');
Route::get('/avance',[recherche_avancementController::class,'recherche'])->middleware(['auth'])->name('avance');
Route::get('/affecta',[recherche_affectationController::class,'recherche'])->middleware(['auth'])->name('affecta');
Route::get('/form',[recherche_formationController::class,'recherche'])->middleware(['auth'])->name('form');
Route::get('/stat',[recherche_statutController::class,'recherche'])->middleware(['auth'])->name('stat');
Route::get('/statut',[annee_statutController::class,'index'])->middleware(['auth'])->name('statut');
Route::post('/statut/getCorps',[annee_statutController::class, 'getCorps'])->middleware(['auth'])->name('getCorps');
Route::post('/statut/getEchelons',[annee_statutController::class, 'getEchelons'])->middleware(['auth'])->name('getEchelons');
Route::post('/statut/getClasses',[annee_statutController::class, 'getClasses'])->middleware(['auth'])->name('getClasses');
Route::post('/statut/getIndices',[annee_statutController::class, 'getIndices'])->middleware(['auth'])->name('getIndices');
Route::post('/affectations/corps',[affectationsController::class,'corps'])->middleware(['auth'])->name('corps');
Route::post('/affectations/echelons',[affectationsController::class,'echelons'])->middleware(['auth'])->name('echelons');
Route::post('/affectations/classes',[affectationsController::class,'classes'])->middleware(['auth'])->name('classes');
Route::post('/affectations/indices',[affectationsController::class,'indices'])->middleware(['auth'])->name('indices');
Route::resource('/affectations',affectationsController::class)->middleware(['auth']);
Route::resource('/employer',EmployerController::class)->middleware(['auth']);
Route::resource('/formation',FormationController::class)->middleware(['auth']);
Route::resource('/statut/form',StatutController::class)->middleware(['auth']);
Route::resource('/avancement',AvancementController::class)->middleware(['auth']);
Route::post('/avancement/getCorps',[AvancementController::class, 'getCorps'])->middleware(['auth'])->name('getCorps');
Route::post('/avancement/getEchelons',[AvancementController::class, 'getEchelons'])->middleware(['auth'])->name('getEchelons');
Route::post('/avancement/getClasses',[AvancementController::class, 'getClasses'])->middleware(['auth'])->name('getClasses');
Route::post('/avancement/getIndices',[AvancementController::class, 'getIndices'])->middleware(['auth'])->name('getIndices');
Route::resource('/affectation',AffectationController::class);
Route::post('/affectation/getServices',[AffectationController::class, 'getServices'])->middleware(['auth'])->name('getServices');
Route::post('/affectation/getFonctions',[AffectationController::class, 'getFonctions'])->middleware(['auth'])->name('getFonctions');
Route::get('/recherche_fiche',[ficheController::class,'index'])->name('recherche_fiche')->middleware(['auth']);
Route::get('/fiche',[ficheController::class,'recherche'])->name('fiche')->middleware(['auth']);
