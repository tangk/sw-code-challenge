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
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->unique();
            $table->renameColumn('name', 'first_name');
            $table->dropColumn('email_verified_at');
            $table->dropRememberToken();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropUnique('users_username_unique');
            $table->dropColumn('username');
            $table->renameColumn('first_name', 'name');
            $table->string('email')->unique(false)->change();
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
        });
    }
};
