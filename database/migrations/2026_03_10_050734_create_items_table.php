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
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('type', ['wapen', 'pantser', 'accessoire', 'overig'])->default('overig');
            $table->enum('rarity', ['gewoon', 'zeldzaam', 'episch', 'legendarisch'])->default('gewoon');
            $table->integer('required_level')->default(1);
            $table->integer('power')->default(0)->unsigned(); // 0-100
            $table->integer('speed')->default(0)->unsigned();
            $table->integer('durability')->default(0)->unsigned();
            $table->integer('magic')->default(0)->unsigned();
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
