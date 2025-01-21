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
        Schema::create('products', function (Blueprint $table) {

            $table->id();
            $table->string('product_name', 255);
            $table->text('description')->nullable();

            // وعند حذفو احذفو من كل الجداول المربوطه علاقه ربط بجدول الاقسام branch_id
            $table->unsignedBigInteger('branch_id');
            $table->foreign('branch_id')->references("id")->on("branches")->onDelete("cascade");
            // علاقه ربط بجدول الاقسام branch_id

            $table->string('Created_by', 255);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};