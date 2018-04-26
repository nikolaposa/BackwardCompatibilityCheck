<?php

declare(strict_types=1);

namespace RoaveTest\ApiCompare\Comparator\BackwardsCompatibility\InterfaceBased;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Roave\ApiCompare\Change;
use Roave\ApiCompare\Changes;
use Roave\ApiCompare\Comparator\BackwardsCompatibility\ClassBased\ClassBased;
use Roave\ApiCompare\Comparator\BackwardsCompatibility\InterfaceBased\UseClassBasedChecksOnAnInterface;
use Roave\BetterReflection\Reflection\ReflectionClass;
use function uniqid;

/**
 * @covers \Roave\ApiCompare\Comparator\BackwardsCompatibility\InterfaceBased\UseClassBasedChecksOnAnInterface
 */
final class UseClassBasedChecksOnAnInterfaceTest extends TestCase
{
    public function testCompare() : void
    {
        $changes = Changes::fromArray([Change::added(uniqid('foo', true), true)]);

        /** @var ClassBased|MockObject $classBased */
        $classBased = $this->createMock(ClassBased::class);
        /** @var ReflectionClass|MockObject $fromInterface */
        $fromInterface = $this->createMock(ReflectionClass::class);
        /** @var ReflectionClass|MockObject $toInterface */
        $toInterface = $this->createMock(ReflectionClass::class);

        $classBased
            ->expects(self::once())
            ->method('compare')
            ->with($fromInterface, $toInterface)
            ->willReturn($changes);

        self::assertSame(
            $changes,
            (new UseClassBasedChecksOnAnInterface($classBased))->compare($fromInterface, $toInterface)
        );
    }
}