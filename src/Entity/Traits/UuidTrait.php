<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Uid\UuidV4;

/**
 * Add `uuid` field to entity.
 * To automatically create uuid during persist, add @ORM\HasLifecycleCallbacks() to your entity annotations.
 */
trait UuidTrait
{

    /**
     * @ORM\Column(type="uuid")
     */
    protected $uuid;

    /**
     * @return UuidV4|null
     */
    public function getUuid(): ?UuidV4
    {
        return $this->uuid;
    }

    /**
     * @param UuidV4 $uuid
     * @return self
     */
    public function setUuid(UuidV4 $uuid): self
    {
        $this->uuid = $uuid;
        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @return self
     */
    public function setUuidAtPrePersist(): self
    {
        if (null === $this->uuid) {
            $this->uuid = Uuid::v4();
        }
        return $this;
    }
}