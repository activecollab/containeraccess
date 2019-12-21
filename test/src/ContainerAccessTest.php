<?php

/*
 * This file is part of the Active Collab ContainerAccess project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\ContainerAccess\Test;

use ActiveCollab\ContainerAccess\ContainerAccessInterface;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Psr\Container\ContainerInterface;

class ContainerAccessTest extends TestCase
{
    public function testWillWorkWithoutContainer()
    {
        $object = new class implements ContainerAccessInterface
        {
            use ContainerAccessInterface\Implementation;
        };

        $this->assertFalse($object->hasContainer());
        $this->assertNull($object->getContainer());
    }

    /**
     * @expectedException \LogicException
     * @expectedExceptionMessage Container is not set
     */
    public function testWillThrowExceptionOnMissingContainer()
    {
        $object = new class implements ContainerAccessInterface
        {
            use ContainerAccessInterface\Implementation;
        };

        $this->assertFalse($object->hasContainer());
        $object->this_is_a_key;
    }

    public function testWillProbeForDependency()
    {
        /** @var ContainerInterface|MockObject $container_mock */
        $container_mock = $this->createMock(ContainerInterface::class);
        $container_mock
            ->expects($this->once())
            ->method('has')
            ->with('this_is_a_key')
            ->willReturn(true);

        $object = new class implements ContainerAccessInterface
        {
            use ContainerAccessInterface\Implementation;
        };
        $object->setContainer($container_mock);

        $this->assertTrue($object->hasContainer());
        $this->assertTrue(isset($object->this_is_a_key));
    }

    public function testWillResolveDependency()
    {
        /** @var ContainerInterface|MockObject $container_mock */
        $container_mock = $this->createMock(ContainerInterface::class);
        $container_mock
            ->expects($this->once())
            ->method('get')
            ->with('this_is_a_key')
            ->willReturn(123456);

        $object = new class implements ContainerAccessInterface
        {
            use ContainerAccessInterface\Implementation;
        };
        $object->setContainer($container_mock);

        $this->assertTrue($object->hasContainer());
        $this->assertSame(123456, $object->this_is_a_key);
    }
}
