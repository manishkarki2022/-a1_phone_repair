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
            // Rename 'name' to 'first_name' and add 'last_name'
            $table->renameColumn('name', 'first_name');
            $table->string('last_name')->after('first_name');

            // Add phone number
            $table->string('phone', 20)->nullable()->after('email');

            // Add date_of_birth and gender
            $table->date('date_of_birth')->nullable()->after('password');
            $table->enum('gender', ['male', 'female', 'other'])->nullable()->after('date_of_birth');

            // Add is_active and role
            $table->boolean('is_active')->default(true)->after('gender');
            $table->enum('role', ['admin', 'customer', 'staff'])->default('customer')->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
       Schema::table('users', function (Blueprint $table) {
            // Rollback changes
            $table->renameColumn('first_name', 'name');
            $table->dropColumn([
                'last_name',
                'phone',
                'date_of_birth',
                'gender',
                'is_active',
                'role',
            ]);
        });
    }
};
