<?php

namespace App\Http\Resources;

use App\Models\Article;
use App\Models\Categorie;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ArticleVenteCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'categorie' => Categorie::where('type', 'vente')->get(),
            'articleAconfectionner' => ArticleResource::collection(Article::all()),
            'articleVente' => $this->collection
        ];
    }


    public function pagination($request, $defaultValue, $pagination)
    {
        return [
            "links" => $defaultValue["meta"]["links"],
            
        ];
    }
}
