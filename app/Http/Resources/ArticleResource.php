<?php

namespace App\Http\Resources;

use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ArticleResource extends JsonResource
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
            'prix' => $this->prix,
            'stock' => $this->stock,
            'categorie' => Categorie::find($this->categorie_id)->libelle,
          //  'ref' => $this->REF,
          //  'photo' => $this->photo,
            // 'fournisseurs' => $this->fournisseurs,
            // 'categorie' => $this->categorie,
        ];
    }
}
