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
        Schema::create('d_os', function (Blueprint $table) {
            $table->id();
            $table->integer('supplier_id')->nullable();
            $table->integer('bill_id')->nullable();
            $table->string('do_date')->nullable();
            $table->decimal('sub_total',14,2)->nullable();
            $table->decimal('vat_amount',10,2)->nullable();
            $table->decimal('discount_amount',10,2)->nullable();
            $table->decimal('other_charge',14,2)->nullable();
            $table->decimal('paid',14,2)->nullable();
            $table->decimal('change_due',14,2)->nullable();
            $table->decimal('total',14,2)->nullable();
            $table->string('status')->nullable();
            $table->unsignedBigInteger('company_id')->nullable();
            $table->unsignedBigInteger('created_by')->nullable();
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('d_os');
    }
};
