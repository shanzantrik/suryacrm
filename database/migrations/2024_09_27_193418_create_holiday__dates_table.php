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
        Schema::create('holiday__dates', function (Blueprint $table) {
            $table->id();
            $table->date('holiday_date'); // Date field for the holiday
            $table->string('description'); // Description of the holiday
            $table->text('religion'); // Religion field
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Foreign key to Category
            $table->foreignId('subcategory_id')->constrained('subcategories')->onDelete('cascade'); // Foreign key to Subcategory
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('holiday__dates');
    }
};
