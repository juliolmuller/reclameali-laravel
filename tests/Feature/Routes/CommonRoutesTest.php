<?php

namespace Tests\Feature\Api;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Tests\TestCase;

class CommonRoutesTest extends TestCase
{
    const INDEX_KEY_TEXT = 'Não sabe a senha?';
    const HOME_KEY_TEXT = 'Bem-vind@';

    private function getCredentials(string $role)
    {
        $user = User::where('first_name', 'Visitante')
            ->whereHas('role', fn(Builder $q) => $q->where('name', $role))
            ->first();

        return [
            '_token'   => csrf_token(),
            'email'    => $user->email,
            'password' => '123456789',
        ];
    }

    public function test_index()
    {
        $response = $this->get(route('index'));
        $response->assertStatus(200);
        $response->assertSee(self::INDEX_KEY_TEXT);
    }

    public function test_index_customer_redirect()
    {
        $user = $this->getUser('customer');
        $url = route('index');

        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response = $this->followingRedirects()->actingAs($user)->get($url);
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_index_attendant_redirect()
    {
        $user = $this->getUser('attendant');
        $url = route('index');

        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response = $this->followingRedirects()->actingAs($user)->get($url);
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_index_manager_redirect()
    {
        $user = $this->getUser('manager');
        $url = route('index');

        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response = $this->followingRedirects()->actingAs($user)->get($url);
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_index_admin_redirect()
    {
        $user = $this->getUser('admin');
        $url = route('index');

        $response = $this->actingAs($user)->get($url);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response = $this->followingRedirects()->actingAs($user)->get($url);
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_home_redirect()
    {
        $url = route('home');

        $response = $this->get($url);
        $response->assertStatus(302);
        $response->assertRedirect(route('index', ['forbidden' => 1]));

        $response = $this->followingRedirects()->get($url);
        $response->assertStatus(200);
        $response->assertSee(self::INDEX_KEY_TEXT);
    }

    public function test_home_customer()
    {
        $response = $this->actingAs($this->getUser('customer'))->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_home_attendant()
    {
        $response = $this->actingAs($this->getUser('attendant'))->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_home_manager()
    {
        $response = $this->actingAs($this->getUser('manager'))->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_home_admin()
    {
        $response = $this->actingAs($this->getUser('admin'))->get(route('home'));
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_signin_as_customer()
    {
        $credentials = $this->getCredentials('customer');
        $url = route('auth.signin');

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response = $this->followingRedirects()->post($url, $credentials);
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_signin_as_attendant()
    {
        $credentials = $this->getCredentials('attendant');
        $url = route('auth.signin');

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response = $this->followingRedirects()->post($url, $credentials);
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_signin_as_manager()
    {
        $credentials = $this->getCredentials('manager');
        $url = route('auth.signin');

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response = $this->followingRedirects()->post($url, $credentials);
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_signin_as_admin()
    {
        $credentials = $this->getCredentials('admin');
        $url = route('auth.signin');

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));

        $response = $this->followingRedirects()->post($url, $credentials);
        $response->assertStatus(200);
        $response->assertSee(self::HOME_KEY_TEXT);
    }

    public function test_signin_missing_email_as_customer()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('customer');

        $response = $this->post($url, [
            '_token' => $credentials['_token'],
            'email'  => $credentials['email'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_missing_password_as_customer()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('customer');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'password' => $credentials['password'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_wrong_email_as_customer()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('customer');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'email'    => "vvv{$credentials['email']}",
            'password' => $credentials['password'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_wrong_password_as_customer()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('customer');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'email'    => $credentials['email'],
            'password' => 'myPassword',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_missing_email_as_attendant()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('attendant');

        $response = $this->post($url, [
            '_token' => $credentials['_token'],
            'email'  => $credentials['email'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_missing_password_as_attendant()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('attendant');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'password' => $credentials['password'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_wrong_email_as_attendant()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('attendant');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'email'    => "vvv{$credentials['email']}",
            'password' => $credentials['password'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_wrong_password_as_attendant()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('attendant');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'email'    => $credentials['email'],
            'password' => 'myPassword',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_missing_email_as_manager()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('manager');

        $response = $this->post($url, [
            '_token' => $credentials['_token'],
            'email'  => $credentials['email'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_missing_password_as_manager()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('manager');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'password' => $credentials['password'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_wrong_email_as_manager()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('manager');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'email'    => "vvv{$credentials['email']}",
            'password' => $credentials['password'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_wrong_password_as_manager()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('manager');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'email'    => $credentials['email'],
            'password' => 'myPassword',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_missing_email_as_admin()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('admin');

        $response = $this->post($url, [
            '_token' => $credentials['_token'],
            'email'  => $credentials['email'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_missing_password_as_admin()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('admin');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'password' => $credentials['password'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_wrong_email_as_admin()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('admin');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'email'    => "vvv{$credentials['email']}",
            'password' => $credentials['password'],
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }

    public function test_signin_wrong_password_as_admin()
    {
        $url = route('auth.signin');
        $credentials = $this->getCredentials('admin');

        $response = $this->post($url, [
            '_token'   => $credentials['_token'],
            'email'    => $credentials['email'],
            'password' => 'myPassword',
        ]);
        $response->assertStatus(302);
        $response->assertRedirect(route('index'));

        $response = $this->post($url, $credentials);
        $response->assertStatus(302);
        $response->assertRedirect(route('home'));
    }
}
