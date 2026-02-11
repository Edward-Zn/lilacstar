<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->foreignId('category_id')->constrained()->cascadeOnDelete();

            $table->string('name');
            $table->string('slug')->unique();

            $table->text('description')->nullable();

            // Optional price
            $table->decimal('price', 10, 2)->nullable();
            $table->char('currency', 3)->default('PLN');

            // Flags for Action-like sections
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_new')->default(false);
            $table->boolean('is_visible')->default(true);
            $table->boolean('in_stock')->default(true);

            $table->timestamps();

            $table->index(['category_id', 'is_visible']);
            $table->index(['is_featured', 'is_visible']);
            $table->index(['is_new', 'is_visible']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
