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
        Schema::create('txn_user_carts', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('user_id');
            $table->string('storage_key', 255);
            $table->longText('storage_value');
            $table->timestamps();

            $table->unique(['user_id', 'storage_key']);
            $table->foreign('user_id')->references('id')->on('txn_users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('txn_user_carts');
    }
};
