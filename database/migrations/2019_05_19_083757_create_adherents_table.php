<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdherentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adherents',function (Blueprint $table) {
            $table->id('id');
            $table->string('nomAd');
            $table->string('prenomAd')->nullable();
            $table->string('adressAd')->nullable();
            $table->string('cpAd')->nullable();
            $table->string('villeAd')->nullable();
            $table->string('emailAd');
            $table->string('password');
            $table->string('profession')->nullable();
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
        Schema::dropIfExists('adherents');
    }
}
