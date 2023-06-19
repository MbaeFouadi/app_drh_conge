<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

class employer extends Authenticatable
{
    use LaratrustUserTrait;
    use HasFactory, Notifiable;
    protected $fillable=['matricule','nom','prenom','date_naissance','lieu_naissance','adresse','telephone','password','email','sexe','statut','nombre_enfant','nombre_charge','naissance','compte_bancaire','statut_id','user_id'];
}
