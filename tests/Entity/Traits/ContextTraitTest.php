<?php
declare(strict_types=1);


namespace App\Tests\Entity\Traits;


use App\Entity\Traits\ContextTrait;
use PHPUnit\Framework\TestCase;

/**
 * Class ContextTraitTest
 * @package App\Tests\Entity\Traits
 */
class ContextTraitTest extends TestCase
{
    /**
     * @test
     * @throws \ReflectionException
     */
    public function settersWork(): void
    {
        /** @var ContextTrait $trait */
        $trait = $this->getMockForTrait(ContextTrait::class);

        self::assertIsArray($trait->getContext());
        self::assertEmpty($trait->getContext());

        $key = 'Sample';
        $value = 'Longer sample text';

        $trait->setContext($key, $value);

        self::assertSame($value, $trait->getContext($key));
        self::assertSame([$key => $value], $trait->getContext());
        self::assertNull($trait->getContext('key'));
    }
}