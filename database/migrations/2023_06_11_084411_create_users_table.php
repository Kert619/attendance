<?php

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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('username', '15')->unique();
            $table->string('password');
            $table->foreignId('trainor_id')->nullable();
            $table->integer('role')->default(0);
            $table->timestamps();

            $table->foreign('trainor_id')
                ->references('id')
                ->on('trainors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
