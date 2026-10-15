<?php

namespace Tests\Feature;

use App\Models\FaceProfile;
use App\Models\FaceVerification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FaceRecognitionTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Embedding dasar (128 dimensi).
     */
    private function embedding(float $value = 0.1): array
    {
        return array_fill(0, 128, $value);
    }

    private function userWithFace(): User
    {
        $user = User::factory()->create(['role' => 'user']);

        FaceProfile::create([
            'user_id' => $user->id,
            'face_embedding' => json_encode($this->embedding()),
        ]);

        return $user;
    }

    public function test_registration_stores_embedding_not_photo(): void
    {
        $user = User::factory()->create(['role' => 'user']);

        $this->actingAs($user)->withSession([
            'face_liveness_challenge' => ['blink', 'left', 'right'],
            'face_liveness_type' => 'registration',
        ]);

        $response = $this->postJson(route('face.registration.store'), [
            'face_embedding' => $this->embedding(),
            'liveness_passed' => true,
            'liveness_sequence' => ['blink', 'left', 'right'],
        ]);

        $response->assertOk()->assertJson(['success' => true]);

        $profile = FaceProfile::where('user_id', $user->id)->firstOrFail();
        $this->assertCount(128, json_decode($profile->face_embedding, true));
    }

    public function test_login_verification_matches_same_face_and_rejects_other_face(): void
    {
        $user = $this->userWithFace();

        // wajah sama (selisih kecil) -> lolos
        $this->actingAs($user)->withSession([
            'otp_verified' => true,
            'face_liveness_type' => 'login',
            'face_liveness_challenge' => ['blink', 'left', 'right'],
        ])->postJson(route('face.verification.verify'), [
            'face_embedding' => array_map(fn ($v) => $v + 0.01, $this->embedding()),
            'liveness_passed' => true,
            'liveness_mode' => 'active',
            'liveness_sequence' => ['blink', 'left', 'right'],
        ])->assertOk()->assertJson(['success' => true]);

        // wajah berbeda -> ditolak
        $this->actingAs($user)->withSession([
            'otp_verified' => true,
            'face_liveness_type' => 'login',
            'face_liveness_challenge' => ['blink', 'left', 'right'],
        ])->postJson(route('face.verification.verify'), [
            'face_embedding' => $this->embedding(0.9),
            'liveness_passed' => true,
            'liveness_mode' => 'active',
            'liveness_sequence' => ['blink', 'left', 'right'],
        ])->assertStatus(422);

        $this->assertDatabaseHas('face_verifications', ['status' => 'success']);
        $this->assertDatabaseHas('face_verifications', ['status' => 'failed']);
    }

    public function test_passive_mode_works_for_transaction_only(): void
    {
        $user = $this->userWithFace();

        $this->actingAs($user)->withSession([
            'face_liveness_type' => 'transaction',
        ])->postJson(route('face.verification.verify'), [
            'face_embedding' => $this->embedding(),
            'liveness_passed' => true,
            'liveness_mode' => 'passive',
        ])->assertOk()->assertJson(['success' => true]);

        // mode pasif untuk login harus ditolak
        $this->actingAs($user)->withSession([
            'otp_verified' => true,
            'face_liveness_type' => 'login',
        ])->postJson(route('face.verification.verify'), [
            'face_embedding' => $this->embedding(),
            'liveness_passed' => true,
            'liveness_mode' => 'passive',
        ])->assertStatus(422);
    }

    public function test_spoof_report_is_blocked_and_logged(): void
    {
        $user = $this->userWithFace();

        $this->actingAs($user)->withSession([
            'face_liveness_type' => 'transaction',
        ])->postJson(route('face.verification.verify'), [
            'face_embedding' => $this->embedding(),
            'liveness_passed' => false,
            'liveness_mode' => 'passive',
            'spoof_suspected' => true,
        ])->assertStatus(422)->assertJson(['spoof_suspected' => true]);

        $this->assertDatabaseHas('face_verifications', [
            'user_id' => $user->id,
            'status' => 'spoof_suspected',
        ]);
    }

    public function test_threshold_is_050(): void
    {
        $user = $this->userWithFace();

        // jarak sekitar 0.55 (di atas 0.5) harus ditolak
        $perDim = 0.55 / sqrt(128);

        $this->actingAs($user)->withSession([
            'face_liveness_type' => 'transaction',
        ])->postJson(route('face.verification.verify'), [
            'face_embedding' => array_map(fn ($v) => $v + $perDim, $this->embedding()),
            'liveness_passed' => true,
            'liveness_mode' => 'passive',
        ])->assertStatus(422);
    }
}
