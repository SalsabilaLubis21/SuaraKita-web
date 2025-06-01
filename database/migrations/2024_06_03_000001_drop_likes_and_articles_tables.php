<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

class DropLikesAndArticlesTables extends Migration
{
    public function up()
    {
        Schema::dropIfExists('likes');
        Schema::dropIfExists('articles');
    }

    public function down()
    {
        // No rollback for dropping tables
    }
}
