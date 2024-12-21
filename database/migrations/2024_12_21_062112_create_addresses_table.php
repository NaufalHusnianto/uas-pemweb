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
        Schema::create('addresses', function (Blueprint $table) {
            $table->id() -> index();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->unsignedBigInteger('province_id');
            $table->string('province_name');
            $table->unsignedBigInteger('regency_id');
            $table->string('regency_name');
            $table->unsignedBigInteger('district_id');
            $table->string('district_name');
            $table->unsignedBigInteger('village_id');
            $table->string('village_name');
            $table->text('detail_address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('addresses');
    }
};
