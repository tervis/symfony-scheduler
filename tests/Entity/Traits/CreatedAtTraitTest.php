<?php
declare(strict_types=1);

namespace App\Tests\Entity\Traits;

use App\Entity\Traits\CreatedAtTrait;
use PHPUnit\Framework\TestCase;

class CreatedAtTraitTest extends TestCase
{

    /**
     * @test
     */
    public function settersWork()
    {
        /** @var CreatedAtTrait $trait */
        $trait = $this->getMockForTrait(CreatedAtTrait::class);
        $this->assertNull($trait->getCreatedAt());

        $trait->setCreatedAtPrePersist();
        $this->assertInstanceOf(\DateTime::class, $trait->getCreatedAt());

        $date = new \DateTime('2020-01-01 12:30:00');
        $trait->setCreatedAt($date);
        $this->assertSame($date, $trait->getCreatedAt());

        $trait->setCreatedAtPrePersist();
        $this->assertSame($date, $trait->getCreatedAt());
    }

}