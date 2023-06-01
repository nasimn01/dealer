<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('d_o_details', function (Blueprint $table) {
            $table->id();
            $table->integer('do_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('total_price',14,2)->nullable();
            $table->decimal('free',14,2)->nullable();
            $table->decimal('price',14,2)->nullable();
            $table->decimal('basic',14,2)->nullable();
            $table->decimal('discount_percent',14,2)->nullable();
            $table->decimal('vat_percent',14,2)->nullable();
            $table->decimal('amount',14,2)->nullable();
            
            $table->string('status')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_o_details');
    }
};
