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
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->string('images');
            $table->date('funded_date');
            $table->integer('purchase_price');
            $table->integer('funder_count');
            $table->integer('rental_income');
            $table->integer('current_rent');
            $table->integer('percent');
            $table->string('location_string');
            $table->integer('property_price_total');
            $table->string('property_price');
            $table->string('current_evaluation');
            $table->string('discount');
            $table->string('estimated_annualised_return');
            $table->string('estimated_annual_appreciation');
            $table->string('estimated_projected_gross_yield');
            $table->integer('service_charge');
            $table->string('status')->nullable();
            $table->timestamp('approved')->nullable();
            $table->foreignId("category_id")->constrained("categories")->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
