<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Reports extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reports', function(Blueprint $table){
            $table->string('id');
            $table->string('campaign');
            $table->string('list_id');
            $table->string('emails_sent');
            $table->integer('abuse_reports');
            $table->integer('unsubscribe');
            $table->integer('hard_bounce');
            $table->integer('soft_bounce');
            $table->integer('opens_total');
            $table->integer('unique_opens');
            $table->integer('open_rate');
            $table->integer('clicks_total');
            $table->integer('unique_clicks');
            $table->integer('unique_subscriber_clicks');
            $table->integer('click_rate');
            $table->integer('sub_rate');
            $table->integer('unsub_rate');
            $table->integer('list_open_rate');
            $table->integer('list_click_rate');
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
         Schema::drop('reports');
    }
}
