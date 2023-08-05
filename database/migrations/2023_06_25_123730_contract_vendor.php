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
        Schema::create('contract_vendor', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contract_id');
            $table->unsignedBigInteger('vendor_id');
            $table->unsignedBigInteger('status_id');
            //dof
            $table->string('no_dof')->nullable();
            $table->date('date_dof')->nullable();
            $table->string('date_name')->nullable();
            //yang menandatangani
            $table->string('management_executives')->nullable();
            $table->string('management_job')->nullable();
            //identitas vendor
            $table->string('vendor_upper')->nullable();
            $table->string('vendor_capital')->nullable();
            $table->string('director')->nullable();
            $table->string('address')->nullable();
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('place_vendor')->nullable();
            //pekerjaan kontrak
            $table->double('prosentase')->nullable();
            $table->integer('contract_amount')->nullable();
            $table->string('state_rate')->nullable();
            $table->integer('minimum_transport')->nullable();
            $table->string('date_sname')->nullable();
            $table->date('start_date')->nullable();
            $table->string('date_ename')->nullable();
            $table->date('end_date')->nullable();
            $table->integer('performance_bond')->nullable();
            $table->string('rupiah')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('name_devdate')->nullable();
            //file
            $table->string('qrcode')->nullable();
            $table->string('filename')->nullable();
            $table->string('final_vendor')->nullable();

            $table->foreign('vendor_id')->references('id')->on('vendors');
            $table->foreign('status_id')->references('id')->on('statuses');
            $table->foreign('contract_id')->references('id')->on('contracts')->onDelete('cascade');
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
