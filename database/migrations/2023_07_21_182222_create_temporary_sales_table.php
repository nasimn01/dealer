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
        Schema::create('temporary_sales', function (Blueprint $table) {
            $table->id();
            $table->string('shop_or_dsr')->nullable();
            $table->string('date')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('ctn')->nullable();
            $table->integer('pcs')->nullable();
            $table->integer('tp')->nullable();
            $table->decimal('tp_price',14,2)->nullable();
            $table->string('status')->default(0);
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
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
        Schema::dropIfExists('temporary_sales');
    }
};
