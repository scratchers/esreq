<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use App\Institution;

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

        $updatedLat = 35.998093;
        $updatedLon = -94.089991;

        $this
            ->get("/institutions/{$institution->id}")
            ->assertSee(e($institution->name))
            ->assertSee((string)$institution->latitude)
            ->assertSee((string)$institution->longitude)
        ;

        $response = $this
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
        $institution = make(Institution::class)->toArray();

        $response = $this
            ->signIn()
            ->post('/institutions', $institution)
            ->assertStatus(302)
        ;

        $this
            ->getJson($response->headers->get('Location'))
            ->assertJson($institution)
        ;
    }
}
