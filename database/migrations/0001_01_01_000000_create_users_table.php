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
        Schema::create('users', function (Blueprint $table) {
            $table->id();

            $table->string('name', 255);

            $table->string('email', 255)->unique();
            $table->string('phone', 50)->unique();

            $table->integer('otp')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('pass_key');
            $table->text('password_reset_token')->nullable();
            $table->timestamp('token_expires_at')->nullable();

            $table->softDeletes();
            $table->rememberToken();
            $table->enum('status', ['Active', 'Inactive', 'Banned'])->default('Active');
            $table->timestamp('created_at')->useCurrent();
            $table->timestamp('updated_at')->useCurrentOnUpdate()->useCurrent();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
