<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Command\Common\Router;

use Ulrack\Command\Common\Command\InputInterface;

interface RouterInterface
{
    /**
     * Resolves the input to a command, executes it and returns the exit code.
     *
     * @param InputInterface $input
     *
     * @return int
     */
    public function __invoke(InputInterface $input): int;
}
