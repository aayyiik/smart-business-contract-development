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
        Schema::create('review_legals', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_vendor_id');
            $table->string('name');
            $table->text('review_contract');
            $table->foreign('contract_vendor_id')->references('id')->on('contract_vendor')->onDelete('cascade')->onUpdate('cascade');
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
        //
    }
};
