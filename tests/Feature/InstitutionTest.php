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
}
