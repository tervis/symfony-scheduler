<?php
declare(strict_types=1);

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Adds `created_at` field to your entity.
 * To automatically set date during persist, add @ORM\HasLifecycleCallbacks() to your entity annotations.
 */
trait CreatedAtTrait
{

    /**
     * @ORM\Column(type="datetime")
     */
    private $createdAt;

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    /**
     * @ORM\PrePersist()
     * @return $this
     */
    public function setCreatedAtPrePersist() : self
    {
        if (null === $this->createdAt) {
            $this->createdAt = new \DateTime();
        }
        return $this;
    }
}