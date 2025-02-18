<?php

declare(strict_types=1);

use App\Models\User;
use Livewire\Volt\Volt;

/**
 * @var \Tests\TestCase $this
 */
describe('Authentication', function (): void {
    test('login screen can be rendered', function (): void {
        $response = $this->get('/login');

        $response
            ->assertOk()
            ->assertSeeVolt('pages.auth.login');
    });

    test('users can authenticate using the login screen', function (): void {
        $user = User::factory()->create();

        $component = Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'password');

        $component->call('login');

        $component
            ->assertHasNoErrors()
            ->assertRedirect(route('dashboard', absolute: false));

        $this->assertAuthenticated();
    });

    test('users can not authenticate with invalid password', function (): void {
        $user = User::factory()->create();

        $component = Volt::test('pages.auth.login')
            ->set('form.email', $user->email)
            ->set('form.password', 'wrong-password');

        $component->call('login');

        $component
            ->assertHasErrors()
            ->assertNoRedirect();

        $this->assertGuest();
    });

    test('users can logout', function (): void {
        $user = User::factory()->create();

        $this->actingAs($user);

        $component = Volt::test('components.logout');

        $component->call('logout');

        $component
            ->assertHasNoErrors()
            ->assertRedirect('/');

        $this->assertGuest();
    });
});
