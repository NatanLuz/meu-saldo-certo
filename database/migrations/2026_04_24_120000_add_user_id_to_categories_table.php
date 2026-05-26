<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('id');
        });

        if (DB::getDriverName() !== 'sqlite') {
            Schema::table('categories', function (Blueprint $table) {
                $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            });
        }

        Schema::table('categories', function (Blueprint $table) {
            $table->dropUnique('categories_name_type_unique');
            $table->unique(['user_id', 'name', 'type']);
            $table->index(['user_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::table('categories', function (Blueprint $table) {
            $table->dropIndex('categories_user_id_type_index');
            $table->dropUnique('categories_user_id_name_type_unique');
            $table->unique(['name', 'type']);

            if (DB::getDriverName() !== 'sqlite') {
                $table->dropForeign(['user_id']);
            }

            $table->dropColumn('user_id');
        });
    }
};
