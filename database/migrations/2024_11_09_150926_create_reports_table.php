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
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId("item_id")->nullable()->constrained();
            $table->foreignId("user_id")->constrained();
            $table->foreignId("location_id")->constrained();
            $table->foreignId("report_status_id")->constrained();
            $table->string("description");
            $table->string("image")->nullable();
            $table->boolean("is_verified")->default(false);
            $table->string("location_lost");
            $table->timestamp("time_lost");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
