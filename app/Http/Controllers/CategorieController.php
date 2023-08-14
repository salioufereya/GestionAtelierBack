<?php

namespace App\Http\Controllers;

use App\Http\Requests\CategorieRequest;
use App\Http\Resources\CategorieResource;
use App\Models\Categorie;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class CategorieController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function all()
    {
        $data =  (Categorie::paginate(3));
        return CategorieResource::collection($data);
        return $this->success($data, 'liste des categories');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(CategorieRequest $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     */
    public function add(Request $request)
    {

        $libelle = $request->libelle;
        $libelle =  ucfirst(strtolower($libelle));

        $libe =  Categorie::onlyTrashed()
            ->where('libelle', $request->libelle)
            ->first();

        if ($libe) {
            $libe->restore();
            return $this->success(new CategorieResource($libe), 'Restauré avec succès', 200);
        } else {
            $categorie = Categorie::create([
                'libelle' => $libelle
            ]);
            return $this->success(new CategorieResource($categorie), 'Ajouté avec succès', 200);
        }
    }

    /**
     * Display the specified resource.
     */
    public function getOne(Request $request)
    {

        $categorie = Categorie::find($request->one);
        if ($categorie) {
            return $this->success('', new CategorieResource($categorie), 200);
        } else {
            return $this->error('', 504, 'Pas de categorie pour cette id');
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(CategorieRequest $request, Categorie $categorie)
    {
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $categorie = Categorie::where('id', $request->categorie)->get();
        $libelle = $request->libelle;
        $libelle =  ucfirst(strtolower($libelle));

        if (count($categorie) == 0) {
            return $this->error('', 504, 'Pas de categorie pour cette id');
        } else {
            $libe =  Categorie::onlyTrashed()
                ->where('libelle', $libelle)
                ->first();
            if ($libe) {
                $libe->restore();
                return $this->success(new CategorieResource($libe), 'Restauré avec succès', 200);
            } else {
                Categorie::where('id', $request->categorie)->update(['libelle' => $libelle]);
                return $this->success($libelle, 'Modifier avec success', 200);
            }
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function delete(Request $request)
    {
        Categorie::whereIn('id', $request->id)->delete();
        return $this->success('Supprimé avec succes', '', 200);
    }

    public function search(Request $request)
    {

        $libelle = $request->libelle;
        if (strlen($libelle) < 3) {
            return $this->error('', 504, 'veillez au moins trois caracteres');
        }
        $libelle =  ucfirst(strtolower($libelle));
        $categorie = Categorie::where('libelle', $libelle)->first();
        if ($categorie) {
            return $this->success(new CategorieResource($categorie), '', 200);
        } else {
            return $this->error('', 504, 'Pas de categorie pour cette id');
        }
    }
}
