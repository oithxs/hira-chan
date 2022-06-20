<?php

namespace Tests\Feature\mail;

use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Verified;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\URL;
use Laravel\Fortify\Features;
use Tests\TestCase;

class RegistrationCancelTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */

    public function test_email_can_be_regstration_cancel()
    {
        if (!Features::enabled(Features::emailVerification())) {
            return $this->markTestSkipped('Email verification not enabled.');
        }

        $user = User::factory()->unverified()->create();

        $registrationCancelUrl = URL::temporarySignedRoute(
            'account/delete',
            now()->addMinutes(60),
            [
                'id' => $user->id,
                'hash' => sha1(
                    $user->id .
                        $user->email .
                        $user->id
                )
            ]
        );

        $response = $this->actingAs($user)->get($registrationCancelUrl);

        $response->assertRedirect('/');
    }
}
