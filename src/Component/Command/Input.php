<?php

/**
 * Copyright (C) GrizzIT, Inc. All rights reserved.
 * See LICENSE for license details.
 */

namespace Ulrack\Command\Component\Command;

use Ulrack\Command\Common\Command\InputInterface;
use Ulrack\Command\Common\Dao\CommandConfigurationInterface;

class Input implements InputInterface
{
    /**
     * Contains the passed command.
     *
     * @var string[]
     */
    private $command;

    /**
     * Contains the passed parameters.
     *
     * @var array
     */
    private $parameters;

    /**
     * Contains the passed flags.
     *
     * @var array
     */
    private $flags;

    /**
     * Contains the loaded command configuration.
     *
     * @var CommandConfigurationInterface
     */
    private $commandConfiguration;

    /**
     * Constructor
     *
     * @param string[] $command
     * @param array    $parameters
     * @param array    $flags
     */
    public function __construct(
        array $command = [],
        array $parameters = [],
        array $flags = []
    ) {
        $this->command = $command;
        $this->parameters = $parameters;
        $this->flags = $flags;
    }

    /**
     * Loads configuration into the input.
     *
     * @param CommandConfigurationInterface $commandConfiguration
     *
     * @return void
     */
    public function loadConfiguration(
        CommandConfigurationInterface $commandConfiguration
    ): void {
        $this->commandConfiguration = $commandConfiguration;
    }

    /**
     * Checks whether the flag is set.
     *
     * @param string $flag
     *
     * @return bool
     */
    public function hasParameter(string $parameter): bool
    {
        if (array_key_exists($parameter, $this->parameters)) {
            return true;
        }

        if ($this->commandConfiguration !== null) {
            foreach (
                $this->commandConfiguration
                ->getParameters() as $parameterInput
            ) {
                $long = $parameterInput['long'] ?? '';
                $short = $parameterInput['short'] ?? '';
                if ($long === $parameter || $short === $parameter) {
                    if (
                        array_key_exists($long, $this->parameters)
                        || array_key_exists($short, $this->parameters)
                    ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Sets the value of a parameter.
     *
     * @param string $parameter
     * @param mixed $value
     *
     * @return void
     */
    public function setParameter(string $parameter, $value): void
    {
        $this->parameters[$parameter] = $value;
    }

    /**
     * Retrieves the parameter from the input.
     *
     * @param string $parameter
     *
     * @return mixed
     */
    public function getParameter(string $parameter)
    {
        if (array_key_exists($parameter, $this->parameters)) {
            return $this->parameters[$parameter];
        }

        if ($this->commandConfiguration !== null) {
            foreach ($this->commandConfiguration->getParameters() as $parameterInput) {
                $long = $parameterInput['long'] ?? '';
                $short = $parameterInput['short'] ?? '';
                if ($long === $parameter || $short === $parameter) {
                    if (array_key_exists($long, $this->parameters)) {
                        return $this->parameters[$long];
                    } elseif (array_key_exists($short, $this->parameters)) {
                        return $this->parameters[$short];
                    }
                }
            }
        }

        return null;
    }

    /**
     * Checks whether the flag is set.
     *
     * @param string $flag
     *
     * @return bool
     */
    public function isSetFlag(string $flag): bool
    {
        if (in_array($flag, $this->flags)) {
            return true;
        }

        if ($this->commandConfiguration !== null) {
            foreach ($this->commandConfiguration->getFlags() as $configFlag) {
                if (
                    $configFlag['long'] === $flag
                    || $configFlag['short'] === $flag
                ) {
                    if (
                        in_array($configFlag['long'], $this->flags)
                        || in_array($configFlag['short'], $this->flags)
                    ) {
                        return true;
                    }
                }
            }
        }

        return false;
    }

    /**
     * Returns the command.
     *
     * @return string[]
     */
    public function getCommand(): array
    {
        return $this->command;
    }

    /**
     * Returns the parameters.
     *
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
    }

    /**
     * Returns the flags.
     *
     * @return array
     */
    public function getFlags(): array
    {
        return $this->flags;
    }
}
