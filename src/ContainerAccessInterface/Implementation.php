<?php

/*
 * This file is part of the Active Collab ContainerAccess project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\ContainerAccess\ContainerAccessInterface;

use ActiveCollab\ContainerAccess\ContainerAccessInterface;
use Psr\Container\ContainerInterface;
use LogicException;

trait Implementation
{
    /**
     * @var ContainerInterface
     */
    private $container;

    public function hasContainer(): bool
    {
        return $this->container instanceof ContainerInterface;
    }

    public function &getContainer(): ?ContainerInterface
    {
        return $this->container;
    }

    public function &setContainer(ContainerInterface &$container): ContainerAccessInterface
    {
        $this->container = $container;

        return $this;
    }

    public function __get($name)
    {
        if ($this->container) {
            return $this->container->get($name);
        }

        throw new LogicException('Container is not set');
    }

    public function __isset($name)
    {
        return $this->container ? $this->container->has($name) : false;
    }
}
