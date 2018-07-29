<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateVoucherCodesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('voucher_codes', function (Blueprint $table) {
            $table->increments('id');
            $table->string('code', 50)->unique();
            $table->boolean('used')->default(false);
            $table->timestamp('expiration_date')->nullable();
            $table->timestamp('usage_date')->nullable();
            $table->integer('recipient_id')->unsigned();
            $table->integer('special_offer_id')->unsigned();
            $table->timestamps();

            $table->foreign('recipient_id')
                ->references('id')
                ->on('recipients')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            $table->foreign('special_offer_id')
                ->references('id')
                ->on('special_offers')
                ->onUpdate('cascade')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('voucher_codes');
    }
}
