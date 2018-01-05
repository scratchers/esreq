<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\User;

class UserTest extends TestCase
{
    use DatabaseMigrations;

    public function test_user_can_view_profile()
    {
        $user = create(User::class);

        $this
            ->signIn($user)
            ->getJson("/users/{$user->id}")
            ->assertJson($user->toArray())
        ;
    }

    public function test_user_can_update_profile()
    {
        $user = create(User::class, ['first_name' => 'JoBob']);

        $response = $this
            ->signIn($user)
            ->patch("/users/{$user->id}", ['first_name' => 'BoJack'])
            ->assertStatus(302)
        ;

        $this
            ->getJson($response->headers->get('Location'))
            ->assertJson(['first_name' => 'BoJack'])
        ;
    }

    public function test_user_cannot_view_your_profile()
    {
        $you = create(User::class);

        $this
            ->withExceptionHandling()
            ->signIn()
            ->get("/users/{$you->id}")
            ->assertStatus(403)
        ;
    }

    public function test_user_cannot_update_your_profile()
    {
        $you = create(User::class);

        $this
            ->withExceptionHandling()
            ->signIn()
            ->patch("/users/{$you->id}", [
                'first_name' => 'BoJack',
            ])
            ->assertStatus(403)
        ;
    }

    public function test_validates_user_is_a_razorback()
    {
        $foreigner = create(User::class);
        $this->assertFalse($foreigner->isRazorback());

        $razorback = create(User::class, ['email' => 'tusk@uark.edu']);
        $this->assertTrue($razorback->isRazorback());
    }
}
