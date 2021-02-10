<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


/**
 * @method static paginate(int $int)
 * @method static findOrFail($id)
 */
class Adherent extends Authenticatable
{
    use Notifiable, HasApiTokens, SoftDeletes;

    protected $guard = 'adherent';
    protected $fillable = ['nomAd', 'emailAd', 'password'];

    protected $hidden = ['password'];

    public function livres()
    {
        return $this->belongsToMany(Livre::class, 'adherent_livre', 'adherent_id', 'livre_id')
            ->withPivot('dateDebut', 'dateFin', 'rendu','deleted_at')
            ->whereNull('adherent_livre.deleted_at')
            ->withTimestamps();
    }

    public function rules(Request $request): array
    {
        return [
            'nomAd' => 'required',
            'prenomAd' => 'required',
            'adressAd' => 'required',
            'cpAd' => 'required',
            'villeAd' => 'required',
            'emailAd' => 'required|email',
            'profession' => 'required',
        ];
    }
}


