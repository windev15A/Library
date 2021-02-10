<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Categorie extends Model
{
    use SoftDeletes;
    protected $fillable =[
      'libCat',
    ];

    public function livres(): BelongsToMany
    {
      return $this->belongsToMany(Livre::class,  'categorie_livre', 'categorie_id', 'livre_id');
    }
}
