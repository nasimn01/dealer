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
        Schema::create('do_receive_histories', function (Blueprint $table) {
            $table->id();
            $table->string('do_id')->nullable();
            $table->string('stock_date')->nullable();
            $table->integer('chalan_no')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('batch_no_id')->nullable();
            $table->integer('ctn')->nullable();
            $table->integer('pcs')->nullable();
            $table->integer('receive_free_qty')->nullable();
            $table->integer('receive_qty')->nullable();
            $table->decimal('dp',14,2)->nullable();
            $table->string('remark')->nullable();
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
        Schema::dropIfExists('do_receive_histories');
    }
};
