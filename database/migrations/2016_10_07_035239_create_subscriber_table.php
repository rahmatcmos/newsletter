<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubscriberTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_subscribers', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('newsletter_list_id');
            $table->string('name', 50);
            $table->string('email', 100);
            $table->enum('status', ['pending', 'subscribed', 'unsubscribed'])->default('unsubscribed');
            $table->timestamps();

            // create index
            $table->index('email', 'SUBSCRIBER_EMAIL_INDEX');
            $table->index('name', 'SUBSCRIBER_NAME_INDEX');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_subscribers');
    }
}
