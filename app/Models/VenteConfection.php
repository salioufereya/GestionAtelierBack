<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VenteConfection extends Model
{

    protected $fillable = ['article_id', 'article_vente_id', 'quantite'];
    use HasFactory;
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
}
