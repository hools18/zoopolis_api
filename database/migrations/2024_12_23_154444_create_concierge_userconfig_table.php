<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConciergeUserconfigTable extends Migration
{
    public function up(): void
    {
        Schema::create('concierge_userconfig', function (Blueprint $table) {
            $table->unsignedBigInteger('user');
            $table->longText('config');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('concierge_userconfig');
    }
}
