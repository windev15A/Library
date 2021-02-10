<?php

namespace App;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @mixin \Eloquent
 */
class Auteur extends Model
{
    use SoftDeletes;
    protected $guarded=[];

    public function livres(): HasMany
    {
      return $this->hasMany(Livre::class);
    }

    public function rules(Request $request){
        return [
            'lastName' => 'required|min:3' ,
            'firstName' => 'required|min:3',
            'nationality' => 'required',
            'birthDate' => 'required|numeric',
        ];
    }
}
