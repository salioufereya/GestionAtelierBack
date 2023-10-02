<?php

use App\Models\Categorie;
use App\Models\Fournisseur;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('libelle')->unique()->nullable(false);
            $table->float('prix')->nullable(false);
            $table->float('stock')->nullable(false);
            $table->foreignIdFor(Categorie::class);
            $table->foreignIdFor(Fournisseur::class);
            $table->string('REF')->nullable(false)->unique();
            $table->text('photo')->nullable()->unique();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
