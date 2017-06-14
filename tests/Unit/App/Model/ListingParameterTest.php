<?php

namespace Tests\Unit\App\Model;

use App\Model\ListingParameters;
use Illuminate\Http\Request;
use Tests\TestCase;

class ListingParameterTest extends TestCase
{
    public function testCreateFromRequest()
    {
        $request = \Mockery::mock(Request::class);

        $request->shouldReceive('get')->with('page', 0)->andReturn(1);
        $request->shouldReceive('get')->with('pageSize', 10)->andReturn(10);
        $request->shouldReceive('get')->with('criteria', [])->andReturn([]);

        $listingParameters = ListingParameters::createFromRequest($request);

        $this->assertInstanceOf(ListingParameters::class, $listingParameters);
        $this->assertEquals(1, $listingParameters->getPage());
        $this->assertEquals(10, $listingParameters->getPageSize());
        $this->assertEquals([], $listingParameters->getCriteria());
    }
}
