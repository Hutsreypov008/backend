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
        Schema::create('spin_rewards', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')
                ->unique()
                ->constrained()
                ->onDelete('cascade');
            $table->string('prize_type'); // discount_5, discount_10, discount_20, discount_30, free_gift
            $table->decimal('discount_percent', 5, 2)->nullable();
            $table->string('coupon_code', 20)->unique();
            $table->boolean('is_used')->default(false);
            $table->timestamp('expires_at');
            $table->timestamp('used_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('spin_rewards');
    }
};
