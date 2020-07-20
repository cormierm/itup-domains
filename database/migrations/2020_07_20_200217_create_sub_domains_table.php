<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubDomainsTable extends Migration
{
    public function up(): void
    {
        Schema::create('sub_domains', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->string('ip');
            $table->string('email');
            $table->date('verified_at')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sub_domains');
    }
}
