<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class InstitutionTest extends TestCase
{
    use DatabaseMigrations;

    public function test_shows_institutions()
    {
        $this
            ->get('/institutions')
            ->assertSee('Institutions')
        ;
    }
}
