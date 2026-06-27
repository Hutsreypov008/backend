<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Products: index category_id and name for faster filtering/sorting
        Schema::table('products', function (Blueprint $table) {
            $table->index('name');
            $table->index('created_at');
        });

        // Orders: index status for faster filtering, and user_id+created_at for faster user lookups
        Schema::table('orders', function (Blueprint $table) {
            $table->index('status');
            $table->index(['user_id', 'created_at']);
        });

        // Order items: index order_id for faster joins, product_id for stock lookups
        Schema::table('order_items', function (Blueprint $table) {
            $table->index('order_id');
            $table->index('product_id');
        });

        // Carts: user_id + created_at for faster user lookups
        Schema::table('carts', function (Blueprint $table) {
            $table->index(['user_id', 'created_at']);
        });

        // Reviews: product_id + created_at for faster product review lookups
        Schema::table('reviews', function (Blueprint $table) {
            $table->index(['product_id', 'created_at']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropIndex(['name']);
            $table->dropIndex(['created_at']);
        });

        Schema::table('orders', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['user_id', 'created_at']);
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->dropIndex(['order_id']);
            $table->dropIndex(['product_id']);
        });

        Schema::table('carts', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'created_at']);
        });

        Schema::table('reviews', function (Blueprint $table) {
            $table->dropIndex(['product_id', 'created_at']);
        });
    }
};
