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
        Schema::create('items', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->foreignId("item_category_id")->constrained();
            $table->foreignId("location_id")->constrained();
            $table->foreignId("item_status_id")->constrained();
            $table->string("name");
            $table->string("description");
            $table->string("location_found");
            $table->timestamp("time_found");
            $table->string("image");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('items');
    }
};
