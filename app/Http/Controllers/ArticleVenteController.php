<?php

namespace App\Http\Controllers;

use App\Http\Requests\ArticleVenteRequest;
use App\Http\Resources\ArticleResource;
use App\Http\Resources\ArticleVenteCollection;
use App\Http\Resources\ArticleVenteResource;
use App\Models\Article;
use App\Models\ArticleVente;
use App\Models\Categorie;
use App\Traits\HttpResponse;
use Exception;
use Illuminate\Http\Request;

class ArticleVenteController extends Controller
{

    use HttpResponse;

    public function index(Request $request)
    {

        // $categorie = Categorie::where('type', 'vente')->get();
        // $article = ArticleVenteResource::collection(ArticleVente::all());
        // $articleConfection = ArticleResource::collection(Article::all());
        // $data = [
        //     'categorie' => $categorie,
        //     'articleVente' => $article,
        //     'articleAconfectionner' => $articleConfection
        // ];
        // return $this->success($data, "liste des article de ventes");

        $byPage = request()->query('item', 1);
        return ArticleVenteCollection::make(ArticleVente::paginate($byPage));
    }

    public function store(Request $request)
    {

        try {
            $tableauAc = $request->articleConfection;
            $libelles = collect($tableauAc)->pluck('libelle')->toArray();
            // $coutFabrication = Article::whereIn('libelle', $libelles)->sum('prix');
            $idCategories = Article::whereIn('libelle', $libelles)->pluck('categorie_id')->toArray();
            $categoriestab = Categorie::whereIn('id', $idCategories)->pluck('libelle')->toArray();
            $isValidate = ['Tissus', 'Boutons', 'Files'];
            $test = array_diff($isValidate, $categoriestab);
            if (!empty($test)) {
                return $this->error("", "donnée non valide");
            }


            // foreach ($tableauAc as $article) {
            //     $libelle = $article['libelle'];
            //     $quantite = $article['quantite'];
            //     $dbQuantite = Article::where('libelle', $libelle)->value('stock');
            //     if ($quantite <= $dbQuantite) {

            //         Article::where('libelle', $libelle)->decrement('stock', $quantite);
            //     } else {
            //         return $this->error("", "quantite non dispobible");
            //     }
            // }

            $data = ArticleVente::create([
                'libelle' => $request->libelle,
                'promo' => $request->promo,
                'ref' => $request->ref,
                'marge' => $request->marge,
                'taille' => $request->taille,
                // 'cout_fabrication' => $coutFabrication,
                // 'prix_vente' => $marge + $coutFabrication,
                'cout_fabrication' => $request->cout_fabrication,
                'prix_vente' => $request->prix_vente,
                'categorie_id' => $request->categorie_id,
                'photo' => $request->photo,
            ]);
            return  $this->success(new ArticleVenteResource($data), 'ajout reussi');
        } catch (\Exception $e) {
            return response()->json(['message' => $e]);
        }
    }


    public function delete(Request $request)
    {
        ArticleVente::where('id', $request->id)->delete();
        return $this->success('Supprimé avec succes', '', 200);
    }

    public function update(Request $request, $libelle)
    {



        try {
            $article = ArticleVente::withTrashed()->find($libelle);
            if ($article->trashed()) {
                $article->restore();
                return $this->success(new ArticleVenteResource($article), 'Article restored successfully', 200);
            } else {
                $article->update([
                    'libelle' => $request->libelle,
                    'promo' => $request->promo,
                    'ref' => $request->ref,
                    'marge' => $request->marge,
                    'taille' => $request->taille,
                    'cout_fabrication' => $request->cout_fabrication,
                    'prix_vente' => $request->prix_vente,
                    'categorie_id' => $request->categorie_id,
                    'photo' => $request->photo,
                ]);

                return $this->success(new ArticleVenteResource($article), 'Article updated successfully', 200);
            }
        } catch (\Exception $e) {
            return $this->error($e->getMessage(), 500);
        }
    }
}
