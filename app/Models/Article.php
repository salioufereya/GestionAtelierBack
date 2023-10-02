<?php

namespace App\Models;

use App\Models\Categorie;
use GuzzleHttp\Psr7\Response;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Article extends Model
{
    use SoftDeletes;
    use HasFactory;
    protected $guarded = ['created_at', 'deleted_at'];
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];

    public function  fournisseurs(): BelongsToMany
    {
        return $this->belongsToMany(Fournisseur::class);
    }


    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    protected static function boot()
    {
        parent::boot();
        static::created(function (Article $article) {
            $fournisseursIds =  explode(',', request()->input('fournisseurChoisis'));      
            $article->fournisseurs()->attach($fournisseursIds);
        });
        static::updated(function ($modele) {
        });
    }
}
