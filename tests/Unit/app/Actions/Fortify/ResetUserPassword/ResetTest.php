<?php

namespace Tests\Unit\app\Actions\Fortify\ResetUserPassword;

use App\Actions\Fortify\ResetUserPassword;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\UseFormRequestTestCase;

class ResetTest extends UseFormRequestTestCase
{
    use RefreshDatabase;

    /**
     * Test user.
     *
     * @var \App\Models\User
     */
    private User $user;

    /**
     * Called first when the setUp method is executed
     *
     * @return void
     */
    protected function setAny(): void
    {
        $this->user = User::factory()->create();
    }

    /**
     * Set the target method.
     *
     * @see UseFormRequestTestCase::setMethod()
     * @return void
     */
    protected function setMethod(): void
    {
        $this->method = [
            new ResetUserPassword,
            'reset'
        ];
    }

    /**
     * Set the arguments of the target method.
     *
     * @see UseFormRequestTestCase::setArgument()
     * @return void
     */
    protected function setArgument(): void
    {
        $this->args = [
            '_token' => 'abcdefghijklmnopqrstuvwsyzABCDEFGHIJKLMN',
            'token' => 'ff9b18e477cc4786873a265cd096fc4255198296775d7793ddcf2f6d4cd262b3',
            'email' => $this->user->email,
            'password' => 'password',
            'password_confirmation' => 'password',
        ];
    }

    /**
     * It is possible to change the arguments of the method under test.
     *
     * @return void
     */
    protected function useMethod(): void
    {
        ($this->method)($this->user, $this->args);
    }

    /**
     * Verify that passwords can be reset by entering various passwords.
     *
     * @return void
     */
    public function test_reset_user_password(): void
    {
        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['password', 'password'])); // Reset password.
        $this->assertFalse($this->useFormRequest(['password', 'password_confirmation'], [Str::random(0), Str::random(0)])); // User password undefined.

        // The number of characters that can't define a user password.
        foreach (range(1, 7) as $num) {
            $password = Str::random($num);
            $this->assertFalse($this->useFormRequest(['password', 'password_confirmation'], [$password, $password]));
        }

        // The number of characters that can define a user password.
        // It is possible to increase the number of digits beyond this.
        foreach (range(8, 255) as $num) {
            $password = Str::random($num);
            $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], [$password, $password]));
        }

        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['abcdefgh', 'abcdefgh'])); // All characters.
        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['12345678', '12345678'])); // All numbers.
        $this->assertFalse($this->useFormRequest(['password', 'password_confirmation'], ['12345678', '87654321'])); // Enter different passwords
        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['abcdefgh', 'abcdefgh'])); // All characters.
        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['12345678', '12345678'])); // All numbers.
        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['!"#$%&\'()-^\\@[;:],./\\=~|`{+*}<>?_', '!"#$%&\'()-^\\@[;:],./\\=~|`{+*}<>?_'])); // Non-alphanumeric password.
    }
}
