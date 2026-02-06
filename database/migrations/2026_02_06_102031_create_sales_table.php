<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('ventes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('utilisateur_id')->constrained('users');
            // $table->foreignId('client_id')->nullable()->constrained('clients'); // On ajoute la contrainte après
            $table->unsignedBigInteger('client_id')->nullable();
            $table->decimal('montant_total', 10, 2);
            $table->string('statut')->default('completed');
            $table->timestamp('date_vente')->useCurrent();
            $table->uuid('id_hors_ligne')->nullable();
            $table->timestamps();
            
            // Ajout de la clé étrangère si la table clients existe déjà, 
            // sinon on devrait changer l'ordre des migrations (renommer le fichier)
            // Pour faire simple ici, on déclare juste la colonne et on indexe.
            $table->index('client_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('ventes');
    }
};
