<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Livre extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'titre',
        'numISBN',
        'description',
        'langueLivre',
        'annee',
        'nbPage',
        'dateAchat',
        'photo',
        'auteur_id'
    ];

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Categorie::class, 'categorie_livre', 'livre_id', 'categorie_id');
    }

    public function auteur(): BelongsTo
    {
        return $this->belongsTo(Auteur::class);
    }
    public function adherents(): BelongsToMany
    {
        return $this->belongsToMany(Adherent::class,'adherent_livre', 'livre_id', 'adherent_id')
            ->withPivot('dateDebut','dateFin','rendu','deleted_at')
            ->whereNull('adherent_livre.deleted_at')
            ->withTimestamps();
    }
}
