<?php

namespace App\Http\Controllers;

use App\Http\Resources\FournisseurResource;
use App\Models\Fournisseur;
use App\Traits\HttpResponse;
use Illuminate\Http\Request;

class FournisseurController extends Controller
{
    use HttpResponse;
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $fournisseur = Fournisseur::all();

        return $this->success(FournisseurResource::collection($fournisseur), '');
    }

    public function search(Request $request)
    {
        $libelle = $request->libelle;
        $libelle = ucfirst(strtolower($libelle));
        $categories = Fournisseur::where('libelle', 'LIKE', '%' . $libelle . '%')->get();
        if ($categories->count() > 0) {
            return $this->success(FournisseurResource::collection($categories), '', 200);
        } else {
            return $this->error('', 504, 'Aucune catégorie correspondante');
        }
    }








    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
