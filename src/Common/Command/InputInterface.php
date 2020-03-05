<?php
/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Command\Common\Command;

use Ulrack\Command\Common\Dao\CommandConfigurationInterface;

interface InputInterface
{
    /**
     * Returns the command.
     *
     * @return array
     */
    public function getCommand(): array;

    /**
     * Returns the parameters.
     *
     * @return array
     */
    public function getParameters(): array;

    /**
     * Returns the flags.
     *
     * @return array
     */
    public function getFlags(): array;

    /**
     * Loads configuration into the input.
     *
     * @param CommandConfigurationInterface $commandConfiguration
     * @return void
     */
    public function loadConfiguration(
        CommandConfigurationInterface $commandConfiguration
    ): void;

    /**
     * Checks whether the flag is set.
     *
     * @param string $parameter
     *
     * @return bool
     */
    public function hasParameter(string $parameter): bool;

    /**
     * Sets the value of a parameter.
     *
     * @param string $parameter
     * @param mixed $value
     *
     * @return void
     */
    public function setParameter(string $parameter, $value): void;

    /**
     * Retrieves the parameter from the input.
     *
     * @param string $parameter
     *
     * @return mixed
     */
    public function getParameter(string $parameter);

    /**
     * Checks whether the flag is set.
     *
     * @param string $flag
     *
     * @return bool
     */
    public function isSetFlag(string $flag): bool;
}
