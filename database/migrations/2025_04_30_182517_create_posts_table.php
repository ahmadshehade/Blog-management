<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
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
            $table->foreignId('category_id')->nullable()->constrained('categories')
                ->nullOnDelete();
            $table->string('title', 255)->unique();
            $table->string('slug')->unique();
            $table->longText('body');
            $table->boolean('is_published')->default(0);
            $table->boolean('is_featured')->default(0);
            $table->boolean('is_scheduled')->default(0);
            $table->enum('status',
                ['draft', 'published', 'archived', 'pending_review'])
                ->default('draft');
            $table->date('publish_date')->nullable();
            $table->string('meta_description', 255)->nullable();
            $table->string('keywords', 255)->nullable();
            $table->string('tags', 255)->nullable();
            $table->string(column: 'canonical_url')->nullable();
            $table->text('editor_notes')->nullable();
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
