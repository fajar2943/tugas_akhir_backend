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
            $table->enum('status', ['Verify', 'Active', 'Banned'])->after('role');
            $table->string('fcm_token')->nullable()->after('status');
            $table->string('notif_token')->nullable()->after('fcm_token');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('status');
            $table->dropColumn('fcm_token');
            $table->dropColumn('notif_token');
        });
    }
};
