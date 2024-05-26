<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Capsule\Manager as Capsule;

return new class extends Migration
{
    public function up()
    {
        Capsule::schema()->create('users', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    public function down()
    {
        Capsule::schema()->dropIfExists('users');
    }
};
