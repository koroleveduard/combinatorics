<?php

namespace Test\Service;

use App\Service\PermutationService;
use PHPUnit\Framework\TestCase;

class PermutationServiceTest extends TestCase
{
    /** @var  PermutationService */
    protected $service;

    public function setUp()
    {
        $this->service = new PermutationService();
    }

    public function testCountPermutation()
    {
        $this->assertEquals(3, $this->service->getCount(3, 2));
        $this->assertEquals(20, $this->service->getCount(6, 3));
        $this->assertEquals(9075135300, $this->service->getCount(36, 18));
    }

    public function testPermutationSets()
    {
        $set = $this->service->getVariants(3, 2);
        $this->assertCount(3, $set);

        $expectedResult = [
            [1,2],
            [1,3],
            [2,3]
        ];

        foreach($set as $key => $combinations) {
            $this->assertArraySubset($combinations, $expectedResult[$key]);
        }
    }
}