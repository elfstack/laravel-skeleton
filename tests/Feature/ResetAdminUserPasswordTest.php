<?php

namespace Tests\Feature;

use App\Models\AdminUser;
use App\Notifications\AdminUserResetPasswordNotification;
use Illuminate\Foundation\Testing\Concerns\InteractsWithDatabase;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetAdminUserPasswordTest extends TestCase
{
    use InteractsWithDatabase;
    use RefreshDatabase;

    /**
     * Prefix of the URL
     */
    private const URL_PREFIX = '/admin/api/admin-users/password';

    protected function setUp(): void
    {
        parent::setUp();

        Notification::fake();
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_send_reset_password_token_email_to_admin_user()
    {
        $adminUser = factory(AdminUser::class)->create();

        $response = $this->postJson(self::URL_PREFIX.'/reset-token', [
            'email' => $adminUser->email
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'success']);

        Notification::assertSentTo(
            [$adminUser],
            AdminUserResetPasswordNotification::class
        );
    }

    public function test_send_reset_password_token_email_to_admin_user_not_exist()
    {
        $response = $this->postJson(self::URL_PREFIX.'/reset-token', [
            'email' => 'thisisaemailthatwillneverexist@example.com'
        ]);

        $response->assertStatus(404)
                 ->assertJson(['message' => 'failed']);
    }

    public function test_check_reset_password_token_is_valid()
    {
        $adminUser = factory(AdminUser::class)->create();
        $token = Password::broker('admin_users')->createToken($adminUser);

        $response = $this->postJson(self::URL_PREFIX.'/reset-token/verify', [
            'email' => $adminUser->email,
            'token' => $token
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'success']);

    }

    public function test_check_reset_password_token_is_invalid()
    {
        $this->withoutExceptionHandling();
        $adminUser = factory(AdminUser::class)->create();
        $token = Password::broker('admin_users')->createToken($adminUser);

        $response = $this->postJson(self::URL_PREFIX.'/reset-token/verify', [
            'email' => 'thisemailneverexist@example.com',
            'token' => $token
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'success']);
    }

    public function test_check_reset_password_user_is_invalid()
    {
        $adminUser = factory(AdminUser::class)->create();
        $anotherAdminUser = factory(AdminUser::class)->create();
        $token = Password::broker('admin_users')->createToken($adminUser);

        $response = $this->postJson(self::URL_PREFIX.'/reset-token/verify', [
            'email' => $anotherAdminUser->email,
            'token' => $token
        ]);

        $response->assertStatus(200)
            ->assertJson(['message' => 'success']);
    }

    public function test_reset_password()
    {
        $this->withoutExceptionHandling();
        $adminUser = factory(AdminUser::class)->create();
        $token = Password::broker('admin_users')->createToken($adminUser);

        $response = $this->putJson(self::URL_PREFIX, [
            'email' => $adminUser->email,
            'token' => $token,
            'password' => 'secret'
        ]);

        $response->assertStatus(200)
                 ->assertJson(['message' => 'success']);

        $adminUser->refresh();

        $isPasswordUpdated = Hash::check('secret', $adminUser->password);
        $this->assertTrue($isPasswordUpdated);
    }

    public function test_reset_password_with_invalid_token()
    {
        $adminUser = factory(AdminUser::class)->create();
        $token = Password::broker('admin_users')->createToken($adminUser);

        $response = $this->putJson(self::URL_PREFIX, [
            'email' => $adminUser->email,
            'token' => $token.'1',
            'password' => 'secret'
        ]);

        $response->assertStatus(410)
                 ->assertJson(['message' => 'failed']);
    }

    public function test_reset_password_with_invalid_user()
    {
        $adminUser = factory(AdminUser::class)->create();
        $token = Password::broker('admin_users')->createToken($adminUser);

        $response = $this->putJson(self::URL_PREFIX, [
            'email' => 'thisuserdoesnotexist@example.com',
            'token' => $token,
            'password' => 'secret'
        ]);

        $response->assertStatus(410)
                 ->assertJson(['message' => 'failed']);
    }
}
