<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('admin_id')->nullable();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('slug')->unique();
            $table->text('summary')->nullable();
            $table->string('cover_image')->nullable();
            $table->longText('content');
            $table->timestamp('published_at')->nullable();
            $table->bigInteger('view_count')->default(0);
            $table->timestamps();

            // $table->foreign('admin_id')->references('id')->on('admins')->onDelete('set null');
            // $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
