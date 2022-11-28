<?php

namespace Tests\Unit\app\Actions\Fortify\CreateNewUser;

use App\Actions\Fortify\CreateNewUser;
use App\Models\User;
use Exception;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use Tests\UseFormRequestTestCase;

class CreateTest extends UseFormRequestTestCase
{
    use RefreshDatabase;

    /**
     * student ID number.
     *
     * @var integer
     */
    private int $number = 10000;

    /**
     * Set the target method.
     *
     * @see UseFormRequestTestCase::setMethod()
     * @return void
     */
    protected function setMethod(): void
    {
        $this->method = [
            new CreateNewUser,
            'create'
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
            'name' => 'laravel',
            'email' => $this->getDummyEmail(),
            'password' => 'password',
            'password_confirmation' => 'password'
        ];
    }

    /**
     * Called first when the useFormRequest method is executed
     *
     * @see UseFormRequestTestCase::reserve()
     * @return void
     */
    protected function reserve(): void
    {
        $this->args['email'] = $this->getDummyEmail();
    }

    /**
     * After returning the student number, increment it.
     *
     * @return string
     */
    private function getDummyEmail(): string
    {
        return 'e1z' . $this->number++;
    }

    /**
     * Verifies that a user is created with various names as arguments.
     *
     * @return void
     */
    public function test_user_creation_on_name(): void
    {
        $this->assertTrue($this->useFormRequest(['name'], ['laravel'])); // User Creation.
        $this->assertTrue($this->useFormRequest(['name'], ['laravel'])); // Duplicate user name.
        $this->assertFalse($this->useFormRequest(['name'], [Str::random(0)])); // User name undefined.

        foreach (range(1, 255) as $num) {
            $this->assertTrue($this->useFormRequest(['name'], [Str::random($num)])); // The number of characters that can define a user name.
        }

        $this->assertFalse($this->useFormRequest(['name'], [Str::random(256)])); // Maximum number of characters in user name exceeded.
        $this->assertTrue($this->useFormRequest(['name'], ['!"#$%&\'()-^\\@[;:],./\\=~|`{+*}<>?_'])); // Non-alphanumeric user name.
    }

    /**
     * Verify that users are created with various emails as arguments.
     *
     * @return void
     */
    public function test_user_creation_on_email(): void
    {
        // Verification of the first character
        foreach (range('a', 'z') as $str) {
            if (strcmp($str, 'e') === 0) {
                $this->assertTrue($this->useFormRequest(['email'], [$str . '1a00000'])); // e1a00000
            } else {
                $this->assertFalse($this->useFormRequest(['email'], [$str . '1a00000']));
            }
        }

        // Verification of the second character.
        // 'a' has already been verified above.
        foreach (range(0, 9) as $num) {
            if ($num === 1) {
                $this->assertTrue($this->useFormRequest(['email'], ['e' . $num . 'b00000'])); // e1b00000
            } else {
                $this->assertFalse($this->useFormRequest(['email'], ['e' . $num . 'b00000']));
            }
        }

        // Verification of the third character.
        foreach (range('a', 'z') as $str) {
            $this->assertTrue($this->useFormRequest(['email'], ['e1' . $str . '98765'])); // e1a99998 ~ e1z99998
        }

        // Verification of last 5 digits.
        // '00000' has already been verified above
        foreach (range(1, 9) as $num) {
            $this->assertTrue($this->useFormRequest(['email'], ['e1a' . 11111 * $num])); // e1a11111, e1a22222, ... , e1a99999
        }

        $this->assertFalse($this->useFormRequest(['email'], ['e1a00000'])); // Duplicate user email.
        $this->assertFalse($this->useFormRequest(['email'], [Str::random(0)])); // User email undefined.
        $this->assertFalse($this->useFormRequest(['email'], [Str::random(255)])); // Maximum string of characters for which a user email can be defined.
        $this->assertFalse($this->useFormRequest(['email'], [Str::random(256)])); // Maximum number of characters in user email exceeded.
        $this->assertFalse($this->useFormRequest(['email'], ['e1a12345@st.oit.ac.jp'])); // With domain name of the email.
        $this->assertFalse($this->useFormRequest(['email'], ['e1b12345' . config('filament.auth.email.domain')])); // With domain name to be used in filament.
    }

    /**
     * Verify that users are created with various passwords as arguments.
     *
     * @return void
     */
    public function test_user_creation_on_password(): void
    {
        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['password', 'password'])); // User Creation.
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
