<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateNewsletterTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletters', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('title', 100);
            $table->string('description', 250);
            $table->text('content');
            $table->dateTime('sent_at');
            $table->enum('status', ['drafted', 'sent'])->default('drafted');
            $table->timestamps();

            // index
            $table->index('title', 'NEWSLETTER_TITLE_INDEX');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletters');
    }
}
