<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\GoogleMaps;
use Zttp\PendingZttpRequest;
use Zttp\ZttpResponse;

class GoogleMapsQueryTest extends TestCase
{
    public function test_instantiates_class()
    {
        $zttp = new PendingZttpRequest;
        $this->assertInstanceOf(GoogleMaps::class, new GoogleMaps($zttp));
    }

    public function test_returns_mock()
    {
        $expected = [
            'lat' => 36.06463197792664,
            'lng' => -94.17427137166595,
        ];

        $stubResponse = $this->createMock(ZttpResponse::class);
        $array['results'][0]['geometry']['location'] = $expected;
        $stubResponse->method('json')
            ->willReturn($array);

        $stubZttp = $this->createMock(PendingZttpRequest::class);
        $stubZttp->method('get')
            ->willReturn($stubResponse);

        $gmaps = new GoogleMaps($stubZttp);

        $this->assertSame($expected, $gmaps->queryLatLng('someplace'));
    }
}
