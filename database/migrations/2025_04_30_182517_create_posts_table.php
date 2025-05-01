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
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')
                ->onDelete('cascade');
            $table->foreignId('admin_id')->nullable()->constrained('admins')
                ->onDelete('cascade');
            $table->string('title',255);
            $table->string('slug');
            $table->longText('body');
            $table->boolean('is_published')->default(0);
            $table->date('publish_date')->nullable();
            $table->string('meta_description',255)->nullable();
            $table->string('tags',255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
