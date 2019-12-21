<?php

/*
 * This file is part of the Active Collab ContainerAccess project.
 *
 * (c) A51 doo <info@activecollab.com>. All rights reserved.
 */

declare(strict_types=1);

namespace ActiveCollab\ContainerAccess;

use Psr\Container\ContainerInterface;

interface ContainerAccessInterface
{
    public function hasContainer(): bool;
    public function &getContainer(): ?ContainerInterface;
    public function &setContainer(ContainerInterface &$container): ContainerAccessInterface;
}
