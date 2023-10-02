<?php

namespace App\Http\Controllers;

use App\Models\Article;
use App\Models\Categorie;
use App\Models\Fournisseur;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;
use App\Models\ArticleFournisseur;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\ArticleRequest;
use App\Http\Resources\ArticleResource;
use App\Traits\Upload;
use Illuminate\Support\Facades\Storage;

class ArticleController extends Controller
{
    use HttpResponse;
    use Upload;
    /**
     * Display a listing of the resource.
     */



    // $libe =  Article::onlyTrashed()
    //     ->where('libelle', $libelle)
    //     ->first();
    // if ($libe) {
    //     $libe->restore();
    //     return $this->success(new ArticleResource($libe), 'Restauré avec succès', 200);
    // } else {
    public function index()
    {
        $categorie = Categorie::all();
        $fournisseur = Fournisseur::all();
        $article = Article::with('categorie', 'fournisseurs')->paginate(5);
        $articleAll = Article::all();
        $data = [
            'categorie' => $categorie,
            'fournisseur' => $fournisseur,
            'article' => $article,
            'articleAll' => $articleAll
        ];
        return $this->success($data, "");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ArticleRequest $request)
    {

        try {
            $libe =  Article::onlyTrashed()
                ->where('libelle', $request->libelle)
                ->first();
            if ($libe) {
                $libe->restore();
                return $this->success(new ArticleResource($libe), 'Restauré avec succès', 200);
            } else {
                $libelle = $request->libelle;
                $libelle =  ucfirst(strtolower($libelle));
                $categorie = $request->categorie_id;
                $data = Article::create([
                    'libelle' => $libelle,
                    'prix' => $request->prix,
                    'stock' => $request->stock,
                    'categorie_id' => $categorie,
                    'photo' => $request->photo,
                    'REF' => $request->ref
                ]);
                return $this->success(new ArticleResource($data), "Article created successfully");
            }
        } catch (\Exception $e) {

            return ["message" => $e->getMessage()];
        }
    }
    public function lastArticle(Request $request)
    {
        $id = Categorie::where('libelle', $request->categorie)->first();
        $count = (Article::where('categorie_id', $id->id))->count() + 1;
        return $count;
    }
    /**
     * Display the specified resource.
     */
    /**
     * Update the specified resource in storage.
     */
    public function editer(Request $request, $libelle)
    {

        try {
            $article = Article::withTrashed()->find($libelle);

            if (!$article) {
                return $this->error('Article not found', 404);
            }

            if ($article->trashed()) {
                $article->restore();
                return $this->success(new ArticleResource($article), 'Article restored successfully', 200);
            } else {
                $article->update([
                    'libelle' => $request->input('libelle'),
                    'prix' => $request->input('prix'),
                    'stock' => $request->input('stock'),
                    'REF' => $request->input('ref'),
                    'photo' => $request->input('photo'),
                    'categorie_id' => $request->input('categorie_id')
                ]);

                $fournisseurs = explode(',', $request->input('fournisseurChoisis'));
                $fournisseurs = array_filter($fournisseurs, function ($fournisseurId) {
                    return !empty($fournisseurId);
                });
                if (!empty($fournisseurs)) {
                    $article->fournisseurs()->sync($fournisseurs);
                }

                return $this->success(new ArticleResource($article), 'Article updated successfully', 200);
            }
        } catch (\Throwable $th) {
            return $this->error($th->getMessage(), 500);
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function delete(Request $request)
    {
        Article::where('id', $request->id)->delete();
        return $this->success('Supprimé avec succes', '', 200);
    }

    public function  chargeData()
    {
        $categorie = Categorie::all();
        $fournisseur = Fournisseur::all();
        $data = [
            'categorie' => $categorie,
            'fournisseur' => $fournisseur
        ];
        return $this->success($data, "");
    }

    public function search(Request $request)
    {
        $libelle = $request->libelle;
        $libelle =  ucfirst(strtolower($libelle));
        $categorie = Article::where('libelle', $libelle)->first();
        if ($categorie) {
            return $this->success(new ArticleResource($categorie), '', 200);
        } else {
            return $this->error('', 504, 'Pas d\'article pour cette id');
        }
    }
}
