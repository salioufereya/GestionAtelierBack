<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Fournisseur extends Model
{
    use HasFactory;
    protected $guarded = ['created_at','deleted_at'];
    public function  articles(): BelongsToMany
    {
        return $this->belongsToMany(Article::class);
    }
    protected $hidden = ['deleted_at', 'created_at','updated_at'];
}
