<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

/**
 * Add context field to entity.
 * This field can be used to store arbitrary data to entity.
 */
trait ContextTrait
{
    /**
     * @var array
     * @ORM\Column(type="json", nullable=true)
     */
    protected array $context = [];

    /**
     * @param string $key
     * @param mixed $value
     * @return self
     */
    public function setContext(string $key, $value): self
    {
        $this->context[$key] = $value;

        return $this;
    }

    /**
     * @param string|null $key
     * @param string|null $default
     * @return array|string
     */
    public function getContext(?string $key = null, $default = null)
    {
        if ($key === null) {
            return $this->context;
        }
        return $this->context[$key] ?? $default;
    }

}
