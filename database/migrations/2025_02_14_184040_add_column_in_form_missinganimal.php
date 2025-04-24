<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnInFormMissinganimal extends Migration
{
    public function up(): void
    {
        Schema::table('form_missinganimal', function (Blueprint $table) {
            $table->uuid('uid')->nullable();
            $table->string('name_finder')->nullable();
            $table->string('phone_finder')->nullable();
            $table->string('address')->nullable();
        });
    }

    public function down(): void
    {
        Schema::table('form_missinganimal', function (Blueprint $table) {
           $table->dropColumn(['uid', 'name_finder', 'phone_finder', 'address']);
        });
    }
}
