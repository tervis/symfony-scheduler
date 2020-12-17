<?php
declare(strict_types=1);

namespace App\Tests\Entity\Traits;

use App\Entity\Traits\UuidTrait;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

class UuidTraitTest extends TestCase
{

    /**
     * @test
     */
    public function settersWork()
    {
        /** @var UuidTrait $trait */
        $trait = $this->getMockForTrait(UuidTrait::class);
        $this->assertNull($trait->getUuid());

        $trait->setUuidAtPrePersist();
        $this->assertInstanceOf(UuidV4::class, $trait->getUuid());

        $uuid = Uuid::v4();
        $trait->setUuid($uuid);
        $this->assertSame($uuid, $trait->getUuid());

        $trait->setUuidAtPrePersist();
        $this->assertSame($uuid, $trait->getUuid());
    }

}