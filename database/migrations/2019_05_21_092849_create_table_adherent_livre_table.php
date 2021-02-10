<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableAdherentLivreTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adherent_livre', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('dateDebut');
            $table->date('dateFin');
            $table->boolean('rendu')->default(0);
            $table->unsignedBigInteger('livre_id');
            $table->foreign('livre_id')->references('id')->on('livres');
            $table->unsignedBigInteger('adherent_id');
            $table->foreign('adherent_id')->references('id')->on('adherents');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('adherent_livre');
    }
}
