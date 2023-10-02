<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class ArticleVente extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = ['libelle', 'promo', 'ref', 'marge', 'taille', 'cout_fabrication', 'prix_vente', 'categorie_id', 'photo', 'updated'];
    public function articleConfections(): BelongsToMany
    {
        return $this->belongsToMany(Article::class, 'vente_confections')
            ->withPivot('quantite');
    }

    public function categorie(): BelongsTo
    {
        return $this->belongsTo(Categorie::class);
    }

    protected static function booted()
    {
        static::created(function (ArticleVente $article) {
            foreach (request()->articleConfection as $confect) {
                $articleConfection = Article::where('libelle', $confect['libelle'])->first();
                if ($articleConfection) {
                    VenteConfection::create([
                        'article_id' => $articleConfection->id,
                        'article_vente_id' => $article->id,
                        "quantite" => $confect['quantite'],
                    ]);
                }
            }
        });

        static::updating(function (ArticleVente $article) {
            $updatedConfections = request()->articleConfection;
            foreach ($updatedConfections as $confect) {
                $articleConfection = Article::where('libelle', $confect['libelle'])->first();

                if ($articleConfection) {
                    $venteConfection = VenteConfection::where('article_vente_id', $article->id)
                        ->where('article_id', $articleConfection->id)
                        ->first();
                    if ($venteConfection) {
                        $venteConfection->update([
                            'quantite' => $confect['quantite'],
                        ]);
                    }
                }
            }
        });
    }
}
