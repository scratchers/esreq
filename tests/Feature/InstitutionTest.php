<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Institution;
use App\User;

class InstitutionTest extends TestCase
{
    use DatabaseMigrations;

    public function test_shows_institutions()
    {
        $institution = create(Institution::class);

        $this
            ->get('/institutions')
            ->assertSee(e($institution->name))
        ;
    }

    public function test_shows_institutions_json()
    {
        $institutions = (create(Institution::class, [], 5))->toArray();

        $this
            ->get('/institutions?json')
            ->assertJson($institutions)
        ;
    }

    public function test_shows_institution_json()
    {
        $institution = create(Institution::class);

        $this
            ->get("/institutions/{$institution->id}?json")
            ->assertJson($institution->toArray())
        ;
    }

    public function test_shows_institution()
    {
        $institution = create(Institution::class);

        $this
            ->get("/institutions/{$institution->id}")
            ->assertSee(e($institution->name))
            ->assertSee((string)$institution->latitude)
            ->assertSee((string)$institution->longitude)
        ;
    }

    public function test_updates_institution()
    {
        $institution = create(Institution::class, [
            'latitude' => 37.4419,
            'longitude' => -122.1419,
        ]);

        $user = create(User::class, ['institution_id' => $institution->id]);

        $updatedLat = 35.998093;
        $updatedLon = -94.089991;

        $this
            ->get("/institutions/{$institution->id}")
            ->assertSee(e($institution->name))
            ->assertSee((string)$institution->latitude)
            ->assertSee((string)$institution->longitude)
        ;

        $response = $this
            ->signIn($user)
            ->put("/institutions/{$institution->id}", [
                'latitude' => $updatedLat,
                'longitude' => $updatedLon,
            ])
            ->assertStatus(302)
        ;

        $this
            ->get($response->headers->get('Location'))
            ->assertSee(e($institution->name))
            ->assertSee((string)$updatedLat)
            ->assertSee((string)$updatedLon)
        ;

        $this
            ->get("/institutions/{$institution->id}")
            ->assertSee(e($institution->name))
            ->assertSee((string)$updatedLat)
            ->assertSee((string)$updatedLon)
        ;
    }

    public function test_creates_institution()
    {
        $user = create(User::class);
        $institution = make(Institution::class)->toArray();

        $response1 = $this
            ->signIn($user)
            ->post('/institutions', $institution)
            ->assertStatus(302)
        ;

        $response2 = $this
            ->getJson($response1->headers->get('Location'))
            ->assertJson($institution)
        ;

        $institution = $response2->decodeResponseJson();

        // assert newly created institution belongs to authenticated user
        $this
            ->getJson("/users/{$user->id}")
            ->assertJson(['institution_id' => $institution['id']])
        ;
    }

    public function test_user_can_only_update_their_institution()
    {
        $elsewhere = create(Institution::class, ['name' => 'elsewhere']);

        $this
            ->withExceptionHandling()
            ->signIn()
            ->patch("/institutions/{$elsewhere->id}", [
                'name' => 'somewhere',
            ])
            ->assertStatus(403)
        ;
    }
}
