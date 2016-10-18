<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsletterListTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('newsletter_lists', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('user_id');
            $table->string('slug', 55)->unique();
            $table->string('name', 50);
            $table->text('description');
            $table->timestamps();

            // table index
            $table->index('name', 'LIST_NAME_INDEX');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('newsletter_lists');
    }
}
