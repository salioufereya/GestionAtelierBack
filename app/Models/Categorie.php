<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categorie extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $guarded = ['created_at', 'deleted_at'];

    public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class);
    }
    protected $hidden = ['deleted_at', 'created_at','updated_at','etat'];
}
