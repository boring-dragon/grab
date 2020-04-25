<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table) {
            $table->id();
            $table->string('source');
            $table->unsignedInteger('comment_id');
            $table->unsignedInteger('post_id');
            $table->string('author_name');
            $table->text('comment');
            $table->unsignedInteger('upvotes')->nullable();
            $table->unsignedInteger('downvotes')->nullable();
            $table->timestamp('date');
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
        Schema::dropIfExists('comments');
    }
}
