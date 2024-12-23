<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRequestCities extends Migration
{
    public function up(): void
    {
        Schema::create('user_request_cities', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('email');
            $table->string('city_name');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('user_request_cities');
    }
}
