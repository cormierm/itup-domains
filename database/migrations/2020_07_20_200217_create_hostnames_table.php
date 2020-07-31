<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHostnamesTable extends Migration
{
    public function up(): void
    {
        Schema::create('hostnames', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('email');
            $table->string('ip');
            $table->dateTime('expires_at')->nullable();
            $table->dateTime('verified_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->string('token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('hostnames');
    }
}
