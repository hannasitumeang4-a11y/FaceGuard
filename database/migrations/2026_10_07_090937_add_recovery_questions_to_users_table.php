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
            $table->string('recovery_question_1')->nullable();
            $table->string('recovery_answer_1')->nullable();

            $table->string('recovery_question_2')->nullable();
            $table->string('recovery_answer_2')->nullable();

            $table->string('recovery_question_3')->nullable();
            $table->string('recovery_answer_3')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'recovery_question_1',
                'recovery_answer_1',
                'recovery_question_2',
                'recovery_answer_2',
                'recovery_question_3',
                'recovery_answer_3',
            ]);
        });
    }
};