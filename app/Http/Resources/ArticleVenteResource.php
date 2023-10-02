<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleVenteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'libelle' => $this->libelle,
            'promo' => $this->promo,
            'marge' => $this->marge,
            'ref' => $this->ref,
            'cout_fabrication' => $this->cout_fabrication,
            'prix_vente' => $this->prix_vente,
            'categorie_id' => $this->categorie_id,
            'photo' => $this->photo,
            'stock' => $this->stock,
            'articleConfection' =>  ArticleBResource::collection($this->articleConfections),
        ];
    }
}
