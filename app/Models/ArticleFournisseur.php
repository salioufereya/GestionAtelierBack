<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArticleFournisseur extends Model
{
    use HasFactory;

    protected  $table = 'article_fournisseur';
    protected $guarded = ['created_at', 'deleted_at'];
    protected $hidden = ['deleted_at', 'created_at', 'updated_at'];
}
