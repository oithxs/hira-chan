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
     * Used for user restore tests.
     * Determines whether to execute the userSoftDelete method.
     *
     * @var boolean
     */
    private bool $restore_flag = false;

    /**
     * User email to be soft deleted.
     *
     * @var string
     */
    private string $deleted_email = 'e1z10000';

    public function setUp(): void
    {
        parent::setUp();
        $this->restore_flag = false;
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
        if ($this->restore_flag) {
            $this->userSoftDelete();
        } else {
            $this->args['email'] = $this->getDummyEmail();
        }
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
     * Executed during user restore test.
     *
     * @return void
     */
    private function userSoftDelete(): void
    {
        // For create exactly the same user.
        $this->setArgument();
        $this->args['email'] = $this->deleted_email;

        try {
            // Delete all users and create new users with the same input.
            User::withTrashed()->forceDelete();
            (new CreateNewUser())->create($this->args);
        } catch (Exception $e) {
            //
        } finally {
            // Perform user SoftDelete.
            User::where('email', '=', $this->deleted_email . '@st.oit.ac.jp')->delete();
        }
    }

    /**
     * Required for user restore test. restore_flag is must be false if user registration test is to be performed later.
     * Verify that the lower two registrations are in a state suitable for user restore testing.
     *
     * Within the test method that calls this method, the useFormRequest method can be called with SoftDeletes for a user whose 'email' is '$this->deleted_email'.
     * Also, the initial value of 'email' in '$this->args' is set to '$this->deleted_email'.
     *
     * @return void
     */
    private function restoreTest(): void
    {
        $this->restore_flag = true;
        $this->assertTrue($this->useFormRequest(['email'], [$this->deleted_email]));
        $this->assertTrue($this->useFormRequest(['email'], [$this->deleted_email]));
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

    /**
     * Verify that it is possible to restore a user with various user names as arguments.
     *
     * @return void
     */
    public function test_name_at_user_restore(): void
    {
        $this->restoreTest();
        $this->assertTrue($this->useFormRequest(['name'], ['laravel'])); // User Creation.
        $this->assertTrue($this->useFormRequest(['name'], ['laravel'])); // Duplicate user name.
        $this->assertFalse($this->useFormRequest(['name'], [Str::random(0)])); // User name undefined.

        foreach (range(1, 255) as $num) {
            $this->assertTrue($this->useFormRequest(['name'], [Str::random($num)])); // The number of characters that can define a user name.
        }

        $this->assertFalse($this->useFormRequest(['name'], [Str::random(256)])); // Maximum number of characters in user name exceeded.
        $this->assertTrue($this->useFormRequest(['name'], ['hoge'])); // Restore user with different user name. ('laravel' -> 'hoge')
    }

    /**
     * Verify that it is possible to restore a user with various user emails as arguments.
     *
     * @return void
     */
    public function test_email_at_user_restore(): void
    {
        // $this->restoreTest();
        $this->markTestSkipped('Changing the Email causes the user to be created instead of restored.');
    }

    /**
     * Verify that it is possible to restore a user with various user passwords as arguments.
     *
     * @return void
     */
    public function test_password_at_user_restore(): void
    {
        $this->restoreTest();
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
        $this->assertTrue($this->useFormRequest(['password', 'password_confirmation'], ['different_passwords', 'different_passwords'])); // Different passwords.
    }
}
