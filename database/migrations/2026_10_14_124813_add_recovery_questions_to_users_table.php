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

            if (!Schema::hasColumn('users', 'role')) {
                $table->string('role')->default('user')->after('password');
            }

            foreach ([1, 2, 3] as $i) {

                if (!Schema::hasColumn('users', "recovery_question_$i")) {
                    $table->string("recovery_question_$i")->nullable();
                }

                if (!Schema::hasColumn('users', "recovery_answer_$i")) {
                    $table->string("recovery_answer_$i")->nullable();
                }
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            foreach ([1, 2, 3] as $i) {
                $table->dropColumn([
                    "recovery_question_$i",
                    "recovery_answer_$i",
                ]);
            }
        });
    }
};