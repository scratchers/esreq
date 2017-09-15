<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\GoogleMaps;

class GoogleMapsQueryTest extends TestCase
{
    public function test_instantiates_class()
    {
        $this->assertInstanceOf(GoogleMaps::class, new GoogleMaps);
    }
}
