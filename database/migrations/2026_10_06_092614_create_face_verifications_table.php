<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('face_verifications', function (Blueprint $table) {

            $table->id();


            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();


            $table->foreignId('face_profile_id')
                ->constrained('face_profiles')
                ->cascadeOnDelete();


            $table->string('verification_type')
                ->default('login');


            $table->boolean('liveness_passed')
                ->default(false);


            $table->boolean('face_matched')
                ->default(false);


            $table->decimal(
                'distance',
                10,
                6
            )->nullable();


            $table->string('status');


            $table->timestamp(
                'verified_at'
            )->nullable();


            $table->timestamps();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists(
            'face_verifications'
        );
    }
};