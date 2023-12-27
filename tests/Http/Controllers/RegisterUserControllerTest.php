<?php
declare(strict_types=1);

namespace Tests\Http\Controllers;

use App\Framework\Decoration\Security\HashInterface;
use Illuminate\Foundation\Testing\LazilyRefreshDatabase;
use Illuminate\Foundation\Testing\RefreshDatabaseState;
use Tests\TestCase;

class RegisterUserControllerTest extends TestCase
{
    use LazilyRefreshDatabase;

    public function refreshDatabase()
    {
        $database = $this->app->make('db');

        $database->beforeExecuting(function () {
            if (RefreshDatabaseState::$lazilyRefreshed) {
                return;
            }

            RefreshDatabaseState::$lazilyRefreshed = true;

            $this->baseRefreshDatabase();
        });
    }


    public static function getTestCases(): array
    {
        return [
            'should register a user' => [
                [
                    'requestData' => [
                        'email' => 'user1@domain.com',
                        'password' => '1234567890',
                    ],
                    'expectedRegisteredUser' => [
                        'email' => 'user1@domain.com',
                        'password' => '1234567890',
                    ],
                ],
            ],
            'should not register a user with an invalid email' => [
                [
                    'requestData' => [
                        'email' => 'user1email',
                        'password' => '1234567890',
                    ],
                    'expectedRegisteredUser' => null,
                ],
            ],
            'should not register a user with a too short password' => [
                [
                    'requestData' => [
                        'email' => 'user2@domain.com',
                        'password' => '123',
                    ],
                    'expectedRegisteredUser' => null,
                ],
            ],
        ];
    }

    /**
     * @param array $testCase
     * @dataProvider getTestCases
     */
    public function test(array $testCase): void
    {
        $this->post('/register', $testCase['requestData']);

        $user = $this
            ->getConnection(null, 'users')
            ->table('users')
            ->where(['email' => $testCase['requestData']['email']])
            ->first();

        if (null === $testCase['expectedRegisteredUser']) {
            static::assertNull($user);

            return;
        }

        /** @var HashInterface $hash */
        $hash = $this->app->make(HashInterface::class);

        static::assertTrue($hash->validate($testCase['expectedRegisteredUser']['password'], $user->password));
    }
}
