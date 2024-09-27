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
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('sales_promoter_name');
            $table->string('salutation');
            $table->string('proprietor_name');
            $table->string('dealer_name');
            $table->string('phone');
            $table->foreignId('category_id')->constrained('categories')->onDelete('cascade'); // Linked to Category
            $table->foreignId('subcategory_id')->constrained('subcategories')->onDelete('cascade'); // Linked to Subcategory
            $table->foreignId('state_id')->constrained('states')->onDelete('cascade'); // Linked to State
            $table->foreignId('district_id')->constrained('districts')->onDelete('cascade'); // Linked to District
            $table->string('pin');
            $table->string('address');
            $table->string('landline_no')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->date('date_of_anniversary')->nullable();
            $table->string('email')->unique();
            $table->string('religion');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('members');
    }
};
